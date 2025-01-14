<?php

use Bronk\CodeAnalyzer\Http\Controllers\CodeAnalyzerController;
use Bronk\CodeAnalyzer\Http\Controllers\FileUploadController;

use Illuminate\Support\Facades\Route;

Route::get('/code-analyzers', [CodeAnalyzerController::class, 'index'])->name('code-analyzers.index');
// Route::get('/code-analyzers/create', [CodeAnalyzerController::class, 'create'])->name('code-analyzers.create');
Route::post('/code-analyzers/upload', [FileUploadController::class, 'upload'])->name('code-analyzers.upload');
// Route::get('/code-analyzers/{code-analyzer}', [CodeAnalyzerController::class, 'show'])->name('code-analyzers.show');
// Route::get('/code-analyzers/{code-analyzer}/edit', [CodeAnalyzerController::class, 'edit'])->name('code-analyzers.edit');
// Route::put('/code-analyzers/{code-analyzer}', [CodeAnalyzerController::class, 'update'])->name('code-analyzers.update');
// Route::delete('/code-analyzers/{code-analyzer}', [CodeAnalyzerController::class, 'destroy'])->name('code-analyzers.destroy');
