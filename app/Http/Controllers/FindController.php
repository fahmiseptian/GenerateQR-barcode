<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Items;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
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
        $item = Items::with('notes')->findOrFail($this->request->id);
        return view('form')
            ->with('item', $item);
    }
    public function note()
    {
        $item = Items::findOrFail($this->request->id);
        return view('note')
            ->with('item', $item);
    }
    public function addNote()
    {
        $validator = Validator::make($this->request->all(), [
            'items_id' => 'required|integer',
            'title' => 'required|string',
            'creator' => 'required|string',
            'content' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route("find.detail", ['id' => $this->request->items_id])->withErrors($validator->errors());
        }

        $note = new Note();
        $note->fill($this->request->except(['_token']));
        $note->save();

        return redirect()->route("find.detail", ['id' => $this->request->items_id])
            ->with('status', 'success')
            ->with('message', 'Note successfully created!');
    }
    public function deleteNote($id, $note_id)
    {
        $note = Note::findOrFail($note_id);
        $note->delete();

        return redirect()->route("find.detail", ['id' => $id])
            ->with('status', 'success')
            ->with('message', 'Note successfully deleted!');
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
