<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BorrowingController;
use App\Http\UserControllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [App\Http\Controllers\BorrowingController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::get('/dashboard/export-excel', [App\Http\Controllers\BorrowingController::class, 'exportExcel'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.excel');

// Semua rute di dalam grup ini WAJIB login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Master Data Barang (Hanya Admin dan Staff)
    Route::middleware(['role:Admin,Staff,Manager'])->group(function() {
        Route::resource('products', ProductController::class);
        Route::put('borrowings/{id}/return', [App\Http\Controllers\BorrowingController::class, 'update'])->name('borrowings.return');
        Route::resource('borrowings',BorrowingController::class)->only (['index', 'create', 'store']);
    });

    Route::middleware(['role:Admin'])->group(function() {
        Route::delete('borrowings/{id}', [App\Http\Controllers\BorrowingController::class, 'destroy'])->name('borrowings.destroy');
        Route::resource('users', \App\Http\Controllers\UserController::class)->only(['index', 'destroy', 'update']);
});
});
require __DIR__.'/auth.php';
