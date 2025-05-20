<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Items;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class FindController extends Controller
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        $item = Items::all();
        return view('find')
            ->with('items', $item);
    }
    public function detail()
    {
        $item = Items::findOrFail($this->request->id);
        return view('form')
            ->with('item', $item);
    }
    public function delete()
    {
        $item = Items::findOrFail($this->request->id);
        $item->delete();
        return Redirect::route('find')
            ->with('status', 'success')
            ->with('message', 'Item successfully deleted!');
    }

    public function print()
    {
        $items = [];
        foreach ($this->request->idArr as $id) {
            $item = Items::findOrFail($id);
            $items[] = [
                'warrantyCode' => $item->warranty_code,
                'unitName' => $item->unit,
                'barcode' => asset($item->barcode),
                'qrcode' => asset($item->qr_code)
            ];
        }

        return view('print', ['items' => $items]);
    }


    public function eksport()
    {
        $items = [];

        foreach ($this->request->idArr as $id) {
            $item = Items::findOrFail($id);
            $items[] = [
                'warrantyCode' => $item->warranty_code,
                'serial_number' => $item->serial_number,
                'customer' => $item->customer,
                'so_number' => $item->so_number,
                'po_number' => $item->po_number,
                'unit' => $item->unit,
                'delivery_date' => $item->delivery_date,
                'installed_date' => $item->installed_date,
                'handover_date' => $item->handover_date,
                'expired_date' => $item->expired_date,
            ];
        }

        return Excel::download(new ItemsExport($items), 'export-items.xlsx');
    }
}
