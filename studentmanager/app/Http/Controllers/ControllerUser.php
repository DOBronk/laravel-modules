<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerUser extends Controller
{
    public function list_students(Request $request)
    {
        $students = Roles::where('name', 'ROLE_STUDENT')->get()->first()->users()->get();

        return view("students.list", [
            'students' => $students,
        ]);
    }
    public function list_mentors(Request $request)
    {
        $mentors = Roles::where('name', 'ROLE_MENTOR')->get()->first()->users()->get();
        return view("mentors.list", [
            'mentors' => $mentors,
        ]);
    }

    public function list_parents(Request $request)
    {
        $parents = Roles::where('name', 'ROLE_PARENT')->get()->first()->users()->get();
        return view("parents.list", [
            'parents' => $parents,
        ]);
    }

    public function show_parent(Request $request)
    {
        return view("parents.show", [
            'parent' => User::where('id', $request->id)->first(),
        ]);
    }

    public function show_student(Request $request, $id)
    {
        // First check if the user is allowed to view this students details
        if (!$request->user()->hasAnyRole(['ROLE_ADMIN', 'ROLE_MENTOR'])) {

        }

        return view("students.show", [
            'student' => User::where('id', $request->id)->first(),
        ]);

    }
}
