<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class ControllerPerson extends Controller
{

    public function list_students(Request $request)
    {
        $students = Roles::where('name', 'ROLE_STUDENT')->get()->first()->users();
        return view("students.list", [
            'students' => $students,
            'user' => $request->user()
        ]);
    }
    public function list_mentors(Request $request)
    {
        $mentors = Roles::where('name', 'ROLE_MENTOR')->get()->first()->users();
        return view("mentors.list", [
            'mentors' => $mentors,
            'user' => $request->user()
        ]);
    }

    public function list_parents(Request $request)
    {
        $parents = Roles::where('name', 'ROLE_PARENT')->get()->first()->users();
        return view("parents.list", [
            'parents' => $parents,
            'user' => $request->user()
        ]);
    }

}
