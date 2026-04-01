<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentHistoryController;
use App\Http\Controllers\DocumentTemplateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin,hr,manager'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employees', EmployeeController::class);
    Route::resource('templates', DocumentTemplateController::class);
    Route::resource('documents', DocumentController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::get('documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::post('documents/{document}/resend', [DocumentController::class, 'resend'])->name('documents.resend');
    Route::get('history', [DocumentHistoryController::class, 'index'])->name('history.index');
    Route::get('history/export', [DocumentHistoryController::class, 'export'])->name('history.export');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/users', \App\Http\Controllers\AdminUserController::class)
        ->except(['show'])
        ->names('admin.users');
});

require __DIR__.'/auth.php';
