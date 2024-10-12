<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessagesController;
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

    Route::middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN,ROLE_PARENT')->group(function () {
        Route::get('/students', [ControllerUser::class, 'list_students'])->name('students.list');
        Route::get('/students/{id}', [ControllerUser::class, 'show_student'])->name('student.show');
        Route::get('/classes/show', [ClassroomController::class, 'index_show'])->name('class.show');
        Route::get('/classes/{id}', [ClassroomController::class, 'show'])->name('class');
        Route::get('/classes', [ClassroomController::class, 'index'])->name('classes.list');
        Route::get('/mentors', [ControllerUser::class, 'list_mentors'])->name('mentors.list');
    });

    Route::middleware(CheckRole::class . ':ROLE_MENTOR,ROLE_ADMIN')->group(function () {
        Route::get('/parents', [ControllerUser::class, 'list_parents'])->name('parents.list');
        Route::post('/parents/show', [ControllerUser::class, 'show_parent'])->name('parent.show');
    });

    Route::middleware(CheckRole::class . ':ROLE_ADMIN')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'show'])->name('admin.users.list');
        Route::post('/admin/create', [AdminController::class, 'create'])->name('admin.users.create');
    });

    Route::resource('/messages', MessagesController::class)->except([
        'update',
        'edit'
    ]);

    Route::get('/message', [MessagesController::class, 'create'])->name('messages.test');

    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/lang/{lang}', function ($lang) {
        Session::put('locale', $lang);
        App::setLocale($lang);
        return back();
    });

});

require __DIR__ . '/auth.php';
