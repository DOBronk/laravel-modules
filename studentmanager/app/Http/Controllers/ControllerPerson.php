<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerPerson extends Controller
{
    public function __construct()
    {

    }
    //
    public function index(Request $request)
    {
        $students = User::all();

        return view("persons.list2", [
            'persons' => $students,
            'user' => $request->user()
        ]);
    }
}
