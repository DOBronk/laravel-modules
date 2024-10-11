<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $users = User::all();
        $roles = Roles::all();

        return view("admin.list-users", [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'roles.*.*.*' => ['required', 'unique:roles', 'bail']
        ]);

        foreach ($request->roles as $key => $user) {
            $userId = explode("-", $key)[1];
            User::find($userId)->roles()->sync($user);
        }
        return back();
    }

}
