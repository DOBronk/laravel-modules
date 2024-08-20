<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControllerPerson;
use App\Http\Controllers\ControllerSchoolclass;
use App\Http\Controllers\ControllerAdmin;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// TODO: Move to controller
Route::get('/dashboard', function (Request $request) {
    return view('dashboard', ['user' => $request->user()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/students', [ControllerPerson::class, 'list_students'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('students.list');
    Route::get('/classes/show', [ControllerSchoolclass::class, 'index_show'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('class.show');
    Route::get('/classes', [ControllerSchoolclass::class, 'index'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('classes.list');
    Route::get('/mentors', [ControllerPerson::class, 'list_mentors'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('mentors.list');
    Route::get('/parents', [ControllerPerson::class, 'list_parents'])->middleware(CheckRole::class . ':ROLE_MENTOR,ROLE_ADMIN')->name('parents.list');
    Route::post('/parents/show', [ControllerPerson::class, 'show_parent'])->middleware(CheckRole::class . ':ROLE_MENTOR,ROLE_ADMIN')->name('parent.show');
    Route::get('/admin/users', [ControllerAdmin::class, 'index'])->middleware(CheckRole::class . ':ROLE_ADMIN')->name('admin.users.list');
    Route::post('/admin/create', [ControllerAdmin::class, 'create'])->middleware(CheckRole::class . ":ROLE_ADMIN")->name('admin.users.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';