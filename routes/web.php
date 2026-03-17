<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page');
});

Route::get('/page', function () {
    return view('page');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');