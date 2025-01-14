<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\View\View;

class MentorsController extends Controller
{
    public function index(): View
    {
        $mentors = Roles::where('name', 'ROLE_MENTOR')->first()->users()->get();

        return view("mentors.list", [
            'mentors' => $mentors,
        ]);
    }
}
