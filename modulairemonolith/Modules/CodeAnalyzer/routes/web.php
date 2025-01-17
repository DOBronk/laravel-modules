<?php

use Illuminate\Support\Facades\Route;
use Modules\CodeAnalyzer\Http\Controllers\CodeAnalyzerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::middleware('auth')->group(function (): void {
        // Create job step 1
        Route::get('codeanalyzer/create-1', [CodeAnalyzerController::class, 'createStepOne'])->name('codeanalyzer.create.step.one');
        Route::post('codeanalyzer/create-1', [CodeAnalyzerController::class, 'postCreateStepOne'])->name('codeanalyzer.create.step.one.post');
        // Create job step 2
        Route::get('codeanalyzer/create-2', [CodeAnalyzerController::class, 'createStepTwo'])->name('codeanalyzer.create.step.two');
        Route::post('codeanalyzer/create-2', [CodeAnalyzerController::class, 'postCreateStepTwo'])->name('codeanalyzer.create.step.two.post');
    });

    Route::resource('codeanalyzer', CodeAnalyzerController::class)->names('codeanalyzer')->middleware('auth');

});
