<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [\App\Http\Controllers\BookController::class, 'index']);
Route::get('/buku/{id}', [\App\Http\Controllers\BookController::class, 'show']);

Route::resource('kategori', \App\Http\Controllers\CategoryController::class)->except('show');

Route::resource('penerbit', \App\Http\Controllers\PublisherController::class)->except('show');

Route::resource('buku', \App\Http\Controllers\BookController::class);
