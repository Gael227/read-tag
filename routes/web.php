<?php

use App\Http\Controllers\AnnotateController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('/book', BookController::class);
Route::post('/book/{book}/progress', [BookController::class, 'updateProgress'])
    ->name('book.update-progress');
Route::resource('/annotate', AnnotateController::class);
Route::get('/search', [BookController::class, 'search'])->name('search.annotate');
