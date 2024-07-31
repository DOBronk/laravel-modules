<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControllerPerson;
use App\Http\Controllers\ControllerSchoolclass;
use App\Http\Controllers\ControllerAdmin;
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
    Route::get('/students', [ControllerPerson::class, 'list_students'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN');
    Route::get('/classes', [ControllerSchoolclass::class, 'index'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN');
    Route::get('/mentors', [ControllerPerson::class, 'list_mentors'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN');
    Route::get('/parents', [ControllerPerson::class, 'list_parents'])->middleware(CheckRole::class . ':ROLE_MENTOR,ROLE_ADMIN');
    Route::get('/admin/users', [ControllerAdmin::class, 'index'])->middleware(CheckRole::class . ':ROLE_ADMIN');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';