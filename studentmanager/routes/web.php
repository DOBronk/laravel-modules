<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MentorsController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\ParentsController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken('test');

        return ['token' => $token->plainTextToken];
    });

    Route::middleware(CheckRole::class . ':ROLE_STUDENT,ROLE_MENTOR,ROLE_ADMIN,ROLE_PARENT')->group(function () {
        Route::get('/students', [StudentsController::class, 'index'])->name('students.list');
        Route::get('/students/{id}', [StudentsController::class, 'show'])->name('student.show');
        Route::get('/classes/show', [ClassroomController::class, 'index_show'])->name('class.show'); // TODO: Aanpassen!!
        Route::get('/classes/{id}', [ClassroomController::class, 'show'])->name('class');            // TODO: Aanpassen!!
        Route::get('/classes', [ClassroomController::class, 'index'])->name('classes.list');
        Route::get('/mentors', [MentorsController::class, 'index'])->name('mentors.list');
    });

    Route::middleware(CheckRole::class . ':ROLE_MENTOR,ROLE_ADMIN')->group(function () {
        Route::get('/parents', [ParentsController::class, 'index'])->name('parents.list');
        Route::post('/parents/show', [ParentsController::class, 'show'])->name('parent.show');
    });

    Route::middleware(CheckRole::class . ':ROLE_ADMIN')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'show'])->name('admin.users.list');
        Route::post('/admin/create', [AdminController::class, 'create'])->name('admin.users.create');
    });

    Route::resource('/messages', MessagesController::class)->except([
        'update',
        'edit'
    ]);

    Route::get('/usersjson', function () {
        return new UserCollection(User::all());
    });

    Route::get('/message', [MessagesController::class, 'create'])->name('messages.test');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
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
