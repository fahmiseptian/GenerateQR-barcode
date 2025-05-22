<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('user.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route("user")->with('status', 'failed')->with('message', $validator->errors());
        }

        $item = new User();
        $item->fill($this->request->except(['_token', 'password', 'password_confirmation', 'role']));
        $item->password = Hash::make($this->request->password);
        $item->role_id = $this->request->role;
        $item->phone = $this->request->phone;
        $item->save();

        return redirect()->route("user")->with('status', 'success')->with('message', 'User created successfully');
    }

    public function editPassword($id)
    {
        $validator = Validator::make($this->request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->with('status', 'failed')->with('message', $validator->errors());
        }

        $user = User::findOrFail($id);
        $user->password = Hash::make($this->request->password);
        $user->save();

        return back()->with('status', 'success')->with('message', 'Updated password successfully');
    }


    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    //     $user = User::findorFail($id);
    //     return view('user.form', compact('user'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::findorFail($id);
        return view('user.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        //
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route("user")->with('status', 'failed')->with('message', $validator->errors());
        }

        $item = User::findorFail($id);
        $item->fill($this->request->except(['_token', 'password', 'password_confirmation', 'role']));
        $item->role_id = $this->request->role;
        $item->phone = $this->request->phone;
        $item->save();

        return redirect()->route("user")->with('status', 'success')->with('message', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findorFail($id);
        $user->delete();
        return redirect()->route('user')->with('status', 'success')->with('message', 'User deleted successfully');
    }

    public function getRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
