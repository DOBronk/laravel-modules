<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schoolclass;
use App\Models\User;

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

    public function index_show(Request $request)
    {
        $class = User::where('id', $request->user()->id)->first();
        return view("classes.show", ['class' => $class->classrooms()->first()]);
    }


    public function show(Request $request)
    {
        $class = Schoolclass::where('id', $request->id)->first();
        return view("classes.show", ['class' => $class]);
    }
}
