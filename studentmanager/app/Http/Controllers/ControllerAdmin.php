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

}
