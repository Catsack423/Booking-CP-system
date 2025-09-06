<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('pages.index');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/guide', function () {
    return view('pages.guide');
})->name('guide');

Route::get('/floor1', function () {
    return view('pages.floor1');
})->name('floor1');

Route::get('/floor2', function () {
    return view('pages.floor2');
})->name('floor2');

Route::get('/floor4', function () {
    return view('pages.floor4');
})->name('floor4');

Route::get('/floor5', function () {
    return view('pages.floor5');
})->name('floor5');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

