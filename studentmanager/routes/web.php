<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControllerPerson;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // This route only for at minimum a student
    Route::get('/persons', [ControllerPerson::class, 'index'])->middleware([CheckRole::class . ':ROLE_MENTOR',CheckRole::class . ':ROLE_STUDENT']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';