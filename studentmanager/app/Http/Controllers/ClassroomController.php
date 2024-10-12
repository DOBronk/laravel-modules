<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classroom::all();

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
        $class = Classroom::where('id', $request->id)->first();
        return view("classes.show", ['class' => $class]);
    }
}
