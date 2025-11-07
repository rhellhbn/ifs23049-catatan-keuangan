<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Jika sudah login, redirect ke transactions
    if (auth()->check()) {
        return redirect()->route('transactions.index');
    }
    // Jika belum login, tampilkan welcome page
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('transactions.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Transaction routes
    Route::get('/statistics', [TransactionController::class, 'statistics'])->name('transactions.statistics');
    Route::resource('transactions', TransactionController::class);
});

require __DIR__.'/auth.php';