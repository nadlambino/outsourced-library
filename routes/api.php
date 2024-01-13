<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('book', BookController::class)->only(['index']);
