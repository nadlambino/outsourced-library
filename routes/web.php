<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::middleware(['auth'])->group(function() {
    Route::controller(PageController::class)->group(function () {
        Route::get('/shelve', 'shelve')->name('shelve');
        Route::get('/library', 'library')->name('library');
    });

    Route::post('/book/borrow', [BookController::class, 'borrow'])->name('book.borrow');
    Route::post('/book/return', [BookController::class, 'return'])->name('book.return');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
