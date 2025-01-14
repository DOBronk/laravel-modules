<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;
use Illuminate\View\View;

class ParentsController extends Controller
{
    public function index(): View
    {
        $parents = Roles::where('name', 'ROLE_PARENT')->first()->users()->get();

        return view("parents.list", [
            'parents' => $parents,
        ]);
    }

    public function show(Request $request): View
    {
        $parent = User::find($request->id);

        if (!isset($parent)) {
            abort(404, 'Parent not found');
        }

        return view("parents.show", [
            'parent' => $parent,
        ]);
    }
}
