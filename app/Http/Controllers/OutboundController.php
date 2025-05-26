<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Items;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Milon\Barcode\DNS1D as BarcodeDNS1D;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OutboundController extends Controller
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        return view('outbound');
    }

    public function add()
    {
        $validator = Validator::make($this->request->all(), [
            'warranty_code' => 'required|string|max:100|unique:items,warranty_code',
            'unit' => 'required|string',
            'serial_number' => 'required|string',
            'customer' => 'required|string',
            'po_number' => 'required|string',
            'so_number' => 'required|string',
            'expired_date' => 'required|integer|min:1|max:5',
            'delivery_date' => 'required|date',
            'installed_date' => 'required|date',
            'handover_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route("outbound")->withErrors($validator->errors());
        }

        $expiredDate = now()->addYears($this->request->expired_date);

        $item = new Items();
        $item->fill($this->request->except(['_token','expired_date']));
        $item->expired_date = $expiredDate;
        $item->save();

        // Generate QR Code
        $qrPath = public_path("qr_codes/{$item->id}_qr.png");
        $qrImage = QrCode::format('png')
            ->size(200)
            ->errorCorrection('H')
            ->generate(route('find.detail', ['id' => $item->warranty_code]));

        file_put_contents($qrPath, $qrImage);


        // Generate Barcode
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = $generator->getBarcode($item->warranty_code, $generator::TYPE_CODE_128);

        $barcodePath = public_path("barcodes/{$item->id}_barcode.png");
        file_put_contents($barcodePath, $barcodeImage);

        // Simpan path ke database jika diperlukan
        $item->qr_code = "qr_codes/{$item->id}_qr.png";
        $item->barcode = "barcodes/{$item->id}_barcode.png";
        $item->save();

        return view('outbound')
            ->with('status', 'success')
            ->with('item', $item)
            ->with('message', 'Item successfully created with QR and Barcode!');
    }
}
