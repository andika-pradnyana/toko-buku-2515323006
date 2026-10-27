<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategori', \App\Http\Controllers\CategoryController::class)->except('show');

Route::resource('penerbit', \App\Http\Controllers\PublisherController::class)->except('show');

Route::resource('buku', \App\Http\Controllers\BookController::class);
