<?php

use App\Http\Controllers\AnnotateController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('/book', BookController::class);
Route::resource('/annotate', AnnotateController::class);
Route::get('/search', [BookController::class, 'search'])->name('search.annotate');
