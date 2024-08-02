<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;

class ControllerAdmin extends Controller
{
    //
    public function index(Request $request)
    {
        $users = User::all();
        $roles = Roles::all();

        return view("admin.list-users", [
            'users' => $users,
            'roles' => $roles,
            'user' => $request->user()
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'roles.*.*.*' => ['required', 'unique:roles', 'bail']
        ]);

        foreach ($request->roles as $key => $user) {
            // TODO: Confirm string begins with roles
            $userId = explode("-", $key)[1];
            User::find($userId)->roles()->sync($user);
        }
        return back();
    }

}
