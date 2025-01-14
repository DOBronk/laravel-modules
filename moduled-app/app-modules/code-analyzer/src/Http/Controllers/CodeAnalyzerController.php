<?php

namespace Bronk\CodeAnalyzer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CodeAnalyzerController
{
    public function index(): View
    {
        return view('code-analyzer::index');
    }
}
