<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::middleware(['auth'])->group(function() {
    Route::get('/shelf', [PageController::class, 'shelf'])->name('shelf');
    Route::get('/library', [PageController::class, 'library'])->name('library');
    Route::get('/history', [PageController::class, 'history'])->name('history');

    Route::post('/book/borrow', [BookController::class, 'borrow'])->name('book.borrow');
    Route::post('/book/return', [BookController::class, 'return'])->name('book.return');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
