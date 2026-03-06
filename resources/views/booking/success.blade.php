@extends('layouts.app')

@section('title', 'Booking Confirmed — TripExplorer')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="glass rounded-2xl p-8 sm:p-12 text-center">
        <!-- Animated Success Icon -->
        <div class="relative w-24 h-24 mx-auto mb-8">
            <div class="absolute inset-0 bg-green-500/20 rounded-full animate-ping"></div>
            <div class="relative w-24 h-24 bg-gradient-to-br from-green-500 to-green-400 rounded-full flex items-center justify-center shadow-lg shadow-green-500/25">
                <i data-lucide="check" class="w-12 h-12 text-white"></i>
            </div>
        </div>

        <h1 class="text-3xl font-black text-white mb-2">Booking Confirmed!</h1>
        <p class="text-gray-400 mb-8">Your reservation has been successfully processed.</p>

        <!-- Booking Reference -->
        <div class="glass-light rounded-2xl p-6 mb-8 max-w-sm mx-auto">
            <div class="text-xs text-gray-400 uppercase tracking-wider mb-1">Booking Reference</div>
            <div class="text-2xl font-black text-primary-400 tracking-widest">{{ $bookingRef }}</div>
        </div>

        <!-- Booking Details -->
        <div class="glass-light rounded-2xl p-6 text-left mb-8">
            <h3 class="text-sm font-bold text-white mb-4">Booking Details</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Type</span>
                    <span class="text-white capitalize">{{ $booking['type'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Item</span>
                    <span class="text-white text-right max-w-[60%]">{{ $booking['item_name'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Guest</span>
                    <span class="text-white">{{ $booking['first_name'] }} {{ $booking['last_name'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Email</span>
                    <span class="text-white">{{ $booking['email'] }}</span>
                </div>
                <div class="flex justify-between text-sm border-t border-white/5 pt-3">
                    <span class="text-sm font-semibold text-white">Total Paid</span>
                    <span class="text-xl font-black text-white">${{ number_format((float)$booking['price'], 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25">
                <i data-lucide="home" class="w-4 h-4"></i> Back to Home
            </a>
            <a href="{{ $booking['type'] === 'hotel' ? route('hotels.search') : route('flights.search') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 glass text-gray-300 hover:text-white font-semibold rounded-xl transition-all">
                <i data-lucide="search" class="w-4 h-4"></i> Search More
            </a>
        </div>

        <p class="text-xs text-gray-500 mt-8">
            ⚠️ This is a demo booking. No real reservation or payment has been made.
        </p>
    </div>
</div>
@endsection