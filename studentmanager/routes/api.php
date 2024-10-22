<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('/auth/token', [AuthController::class, 'generateToken']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum', 'abilities:super-user');
