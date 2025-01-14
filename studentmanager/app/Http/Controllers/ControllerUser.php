<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerUser extends Controller
{
    public function list_students(Request $request)
    {
        $students = Roles::where('name', 'ROLE_STUDENT')->first()->users()->get();

        return view("students.list", [
            'students' => $students,
        ]);
    }
    public function list_mentors(Request $request)
    {
        $mentors = Roles::where('name', 'ROLE_MENTOR')->first()->users()->get();

        return view("mentors.list", [
            'mentors' => $mentors,
        ]);
    }

    public function list_parents(Request $request)
    {
        $parents = Roles::where('name', 'ROLE_PARENT')->first()->users()->get();

        return view("parents.list", [
            'parents' => $parents,
        ]);
    }

    public function show_parent(Request $request)
    {
        $parent = User::find($request->id);

        if (!isset($parent)) {
            abort(404, 'Parent not found');
        }

        return view("parents.show", [
            'parent' => $parent,
        ]);
    }

    public function show_student(Request $request, $id)
    {
        $student = User::find($id);

        if (!isset($student)) {
            abort(404, 'Student not found');
        }

        // Check if the user is allowed to view this student's details
        if (!$request->user()->hasAnyRole(['ROLE_ADMIN', 'ROLE_MENTOR']) && !$request->user()->isRelatedToStudent($id)) {
            abort(401, "Unauthorized");
        }

        return view("students.show", [
            'student' => $student,
        ]);
    }
}
