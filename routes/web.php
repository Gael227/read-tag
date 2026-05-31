<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AnnotateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('/book', BookController::class);
Route::resource('/annotate', AnnotateController::class);