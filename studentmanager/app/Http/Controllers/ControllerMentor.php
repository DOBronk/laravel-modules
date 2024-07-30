<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ControllerMentor extends Controller
{
    //
    public function index(Request $request)
    {
        $mentors = User::all();

        return view("mentors.list", [
            'mentors' => $mentors,
            'user' => $request->user()
        ]);
    }

}
