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

        foreach ($request->roles as $uid => $user) {
            $userId = explode("-", $uid)[1];
            $update_user = User::find($userId);
            $update_user->roles()->sync($user);
            //  $update_user->roles()->updateEzx
            //   var_dump($user);
        }
        //    print (route('admin.users.list'));
        //     back();
        return redirect(route('admin.users.list'));
        //   var_dump($request->input());
    }

}
