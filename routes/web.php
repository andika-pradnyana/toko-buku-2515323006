<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [\App\Http\Controllers\BookController::class, 'index']);
Route::get('/buku/{id}', [\App\Http\Controllers\BookController::class, 'show']);
