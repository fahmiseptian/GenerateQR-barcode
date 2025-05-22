<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    public function store(){
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route("user")->with('status', 'failed')->with('message', $validator->errors());
        }

        $role = new Role();
        $role->name = $this->request->name;
        $role->save();

        return redirect()->route("user")->with('status', 'success')->with('message', 'Role created successfully');
    }

    public function destroy($id){
        $role = Role::find($id);
        $role->delete();
        return redirect()->route("user")->with('status', 'success')->with('message', 'Role deleted successfully');
    }
}
