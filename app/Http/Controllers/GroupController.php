<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Grup;
use App\Models\Grup_item;
use App\Models\Items;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Grup::all();
        return view('group')->with('groups', $groups);
    }

    public function add()
    {
        return view('from-group');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $group = new Grup();
        $group->name = $request->name;
        $group->save();
        return redirect()->route('group')->with('status', 'success')->with('message', 'group created successfully');
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $group = Grup::find($request->id);
        $group->name = $request->name;
        $group->save();
        return redirect()->route('group')->with('status', 'success')->with('message', 'group updated successfully');
    }

    public function detail($id)
    {
        $data  = Grup::with('grupitem.item')->findOrFail($id);
        $items = Items::all();
        return view('from-group', compact('data', 'items'));
    }

    public function storeDetail(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'group_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $groupitem = new Grup_item();
        $groupitem->grup_id = $request->group_id;
        $groupitem->item_id = $request->item_id;
        $groupitem->save();
        return redirect()->route('group.detail', ['id' => $request->group_id])->with('status', 'success')->with('message', 'Product group created successfully');
    }

    public function deleteDetail(Request $request)
    {
        $groupitem = Grup_item::findOrFail($request->idgrupitem);
        $groupitem->delete();
        return redirect()->route('group.detail', ['id' => $request->id])->with('status', 'success')->with('message', 'Product group deleted successfully');
    }


    public function delete($id)
    {
        $group = Grup::find($id);
        $group->delete();
        return redirect()->route('group')->with('status', 'success')->with('message', 'group deleted successfully');
    }
}
