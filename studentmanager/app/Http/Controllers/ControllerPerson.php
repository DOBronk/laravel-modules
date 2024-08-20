<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerPerson extends Controller
{

    public function list_students(Request $request)
    {
        $students = Roles::where('name', 'ROLE_STUDENT')->get()->first()->users()->get();

        return view("students.list", [
            'students' => $students,
            'user' => $request->user()
        ]);
    }
    public function list_mentors(Request $request)
    {
        $mentors = Roles::where('name', 'ROLE_MENTOR')->get()->first()->users()->get();
        return view("mentors.list", [
            'mentors' => $mentors,
            'user' => $request->user()
        ]);
    }

    public function list_parents(Request $request)
    {
        $parents = Roles::where('name', 'ROLE_PARENT')->get()->first()->users()->get();
        return view("parents.list", [
            'parents' => $parents,
            'user' => $request->user()
        ]);
    }

    public function show_parent(Request $request)
    {
        return view("parents.show", [
            'parent' => User::where('id', $request->id)->first(),
            'user' => $request->user()
        ]);
    }


}
