<?php

use App\Http\Controllers\AdminBookingContrller;
use App\Http\Controllers\BookingContrller;
use App\Http\Controllers\Floor1Controller;
use App\Http\Controllers\Floor2Controller;
use App\Http\Controllers\Floor4Controller;
use App\Http\Controllers\Floor5Controller;

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\historyadmin;

use Illuminate\Support\Facades\Mail;
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
    Route::get('/floor2', [Floor2Controller::class,'index'])->name('floor2');
    Route::get('/floor4', [Floor4Controller::class,'index'])->name('floor4');
    Route::get('/floor5', [Floor5Controller::class,'index'])->name('floor5');
    Route::get('/booking/{room}', [BookingContrller::class, 'index'])->name('booking.index');
    Route::get('/booking/{roomId?}/{date?}', [BookingContrller::class, 'show'])->name('booking.show');
    Route::post('/booking', [BookingContrller::class, 'store'])->name('booking.store');
    Route::get('/history', [HistoryController::class, 'index'])->name('HistoryBooking');
    Route::post('/history/booking/{id}', [HistoryController::class, 'update'])->name('booking.update');
    Route::delete('/history/booking/{id}', [HistoryController::class, 'destroy'])->name('booking.destroy');
    
 


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
       Route::get('/historyadmin', [AdminBookingContrller::class, 'index'])->name('historyadmin');
    Route::post('/historyadmin/{id}/approve', [AdminBookingContrller::class, 'approve'])->name('historyadmin.approve');
    Route::post('/historyadmin/{id}/reject',  [AdminBookingContrller::class, 'reject'])->name('historyadmin.reject');
    Route::post('/historyadmin/{id}/update',  [AdminBookingContrller::class, 'update'])->name('historyadmin.update');
    Route::delete('/historyadmin/{id}', [AdminBookingContrller::class, 'destroy'])
        ->name('historyadmin.destroy');
});


Route::get('/mail-test', function () {
    try {
        Mail::raw('ทดสอบส่งเมลผ่าน Gmail SMTP', function ($m) {
            $m->to('your_target_email@gmail.com')->subject('Test Gmail SMTP');
        });
        return '✅ ส่งแล้ว ลองเช็คกล่องเมลปลายทาง';
    } catch (\Throwable $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

