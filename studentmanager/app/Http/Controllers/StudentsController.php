<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function index(): View
    {
        $students = Roles::where('name', 'ROLE_STUDENT')->first()->users()->get();

        return view("students.list", [
            'students' => $students,
        ]);
    }
    public function show(Request $request, string $id): View
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
