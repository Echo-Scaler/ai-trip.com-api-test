<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Localization & Currency Switchers
Route::get('/locale/language/{locale}', [LocaleController::class, 'setLanguage'])->name('locale.language');
Route::get('/locale/currency/{currency}', [LocaleController::class, 'setCurrency'])->name('locale.currency');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Hotels
Route::get('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');
Route::post('/hotels/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Flights
Route::get('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flights.show');

// Booking
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// AI Chatbot
Route::post('/chat', [ChatController::class, 'chat'])->name('chat.send');
Route::post('/chat/clear', [ChatController::class, 'clear'])->name('chat.clear');
