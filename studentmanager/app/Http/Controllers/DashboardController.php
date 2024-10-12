<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class DashboardController extends Controller
{
    const ROLES = ['ROLE_STUDENT', 'ROLE_MENTOR', 'ROLE_PARENT', 'ROLE_ADMIN'];
    public function show(Request $request)
    {
        $displayRoles = $request->user()->roles->filter(function (Role $role) {
            return in_array($role->name, DashboardController::ROLES);
        })->map(function (Role $role) {
            return __($role->name);
        })->implode(', ');

        return view('dashboard', [
            'user' => $request->user(),
            'roles' => $displayRoles,
            'studentclasses' => $request->user()->classrooms,
            'mentorclasses' => $request->user()->mentorOf,
            'children' => $request->user()->children,
        ]);
    }
}
