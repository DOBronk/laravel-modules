<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControllerPerson;
use App\Http\Controllers\ControllerSchoolclass;
use App\Http\Controllers\ControllerAdmin;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/students', [ControllerPerson::class, 'list_students'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('students.list');
    Route::get('/students/{id}', [ControllerPerson::class, 'show_student'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('student.show');
    Route::get('/classes/show', [ControllerSchoolclass::class, 'index_show'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('class.show');
    Route::get('/classes/{id}', [ControllerSchoolclass::class, 'show'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('class');
    Route::get('/classes', [ControllerSchoolclass::class, 'index'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('classes.list');
    Route::get('/mentors', [ControllerPerson::class, 'list_mentors'])->middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN')->name('mentors.list');
    Route::get('/parents', [ControllerPerson::class, 'list_parents'])->middleware(CheckRole::class . ':ROLE_MENTOR,ROLE_ADMIN')->name('parents.list');
    Route::post('/parents/show', [ControllerPerson::class, 'show_parent'])->middleware(CheckRole::class . ':ROLE_MENTOR,ROLE_ADMIN')->name('parent.show');
    Route::get('/admin/users', [ControllerAdmin::class, 'index'])->middleware(CheckRole::class . ':ROLE_ADMIN')->name('admin.users.list');
    Route::post('/admin/create', [ControllerAdmin::class, 'create'])->middleware(CheckRole::class . ":ROLE_ADMIN")->name('admin.users.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/lang/{lang}', function ($lang) {
        Session::put('locale', $lang);
        App::setLocale($lang);
        return back();
    });
    Route::get('/dashboard', function (Request $request) {
        return view('dashboard', ['user' => $request->user()]);
    })->name('dashboard');
});


require __DIR__ . '/auth.php';