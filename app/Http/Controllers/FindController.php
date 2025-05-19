<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Items;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
}
