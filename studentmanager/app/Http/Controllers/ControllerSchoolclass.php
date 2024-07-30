<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schoolclass;

class ControllerSchoolclass extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::all();

        return view("classes.list", [
            'classes' => $classes,
            'user' => $request->user()
        ]);
    }
}
