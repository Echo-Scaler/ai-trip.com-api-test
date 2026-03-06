<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Hotels
Route::get('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');

// Flights
Route::get('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flights.show');

// Booking
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// AI Chatbot
Route::post('/chat', [ChatController::class, 'chat'])->name('chat.send');
Route::post('/chat/clear', [ChatController::class, 'clear'])->name('chat.clear');
