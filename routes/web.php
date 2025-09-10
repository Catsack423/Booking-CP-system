<?php

use App\Http\Controllers\Floor1Controller;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return view('pages.index');
// })->name('home');






Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/about', function () {
        return view('pages.about');
    })->name('about');


    Route::get('/guide', function () {
        return view('pages.guide');
    })->name('guide');

   Route::get('/floor1', [Floor1Controller::class,'index'])->name('floor1');

    Route::get('/floor2', function () {
        return view('pages.floor2');
    })->name('floor2');

    Route::get('/floor4', function () {
        return view('pages.floor4');
    })->name('floor4');

    Route::get('/floor5', function () {
        return view('pages.floor5');
    })->name('floor5');

    Route::get('/Booking', function () {
        return view('pages.Booking');
    })->name('Booking');


    Route::get('/profile', function () {
    return view('profile');
    })->name('profile');


});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/loginadmin', function () {
        return view('auth.loginAdmin');
    });
});