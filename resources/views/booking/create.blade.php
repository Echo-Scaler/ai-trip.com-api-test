@extends('layouts.app')

@section('title', 'Book Your Trip — TripExplorer')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-white">Booking</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <!-- Booking Form -->
        <div class="lg:col-span-3">
            <div class="glass rounded-2xl p-6 sm:p-8">
                <h1 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-white"></i>
                    </div>
                    Complete Your Booking
                </h1>

                <!-- Progress Steps -->
                <div class="flex items-center gap-2 mb-8">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-xs font-bold text-white">1</div>
                        <span class="text-sm font-medium text-white">Details</span>
                    </div>
                    <div class="flex-1 h-px bg-white/10"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-bold text-gray-400">2</div>
                        <span class="text-sm text-gray-500">Confirm</span>
                    </div>
                </div>

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <input type="hidden" name="type" value="{{ $bookingData['type'] }}">
                    <input type="hidden" name="item_id" value="{{ $bookingData['item_id'] }}">
                    <input type="hidden" name="item_name" value="{{ $bookingData['item_name'] }}">
                    <input type="hidden" name="price" value="{{ $bookingData['price'] }}">
                    <input type="hidden" name="currency" value="{{ $bookingData['currency'] }}">

                    <!-- Traveller Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-primary-400"></i> Traveller Information
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">First Name *</label>
                                <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all"
                                    placeholder="John">
                                @error('first_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all"
                                    placeholder="Doe">
                                @error('last_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <i data-lucide="mail" class="w-5 h-5 text-primary-400"></i> Contact Information
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Email *</label>
                                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all"
                                    placeholder="john@example.com">
                                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Phone *</label>
                                <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all"
                                    placeholder="+1 234 567 8900">
                                @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-600/25 hover:shadow-primary-500/40 text-lg flex items-center justify-center gap-2">
                            <i data-lucide="shield-check" class="w-5 h-5"></i> Confirm Booking
                        </button>
                        <p class="text-center text-xs text-gray-500 mt-3">
                            This is a demo. No real payment will be processed.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Booking Summary Sidebar -->
        <div class="lg:col-span-2">
            <div class="glass rounded-2xl p-6 sticky top-24">
                <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="receipt" class="w-4 h-4 text-primary-400"></i> Booking Summary
                </h3>

                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/5">
                    <div class="w-12 h-12 rounded-xl {{ $bookingData['type'] === 'hotel' ? 'bg-purple-500/10' : 'bg-blue-500/10' }} flex items-center justify-center">
                        <i data-lucide="{{ $bookingData['type'] === 'hotel' ? 'building-2' : 'plane' }}" class="w-6 h-6 {{ $bookingData['type'] === 'hotel' ? 'text-purple-400' : 'text-blue-400' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-gray-400 uppercase tracking-wider">{{ $bookingData['type'] }}</div>
                        <div class="text-sm font-semibold text-white truncate">{{ $bookingData['item_name'] }}</div>
                    </div>
                </div>

                <div class="space-y-2 mb-4 pb-4 border-b border-white/5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Base price</span>
                        <span class="text-white">${{ number_format((float)$bookingData['price'] * 0.85, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Taxes & fees</span>
                        <span class="text-white">${{ number_format((float)$bookingData['price'] * 0.15, 2) }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-white">Total</span>
                    <span class="text-2xl font-black text-white">${{ number_format((float)$bookingData['price'], 2) }}</span>
                </div>

                <div class="mt-4 p-3 rounded-xl bg-green-500/5 border border-green-500/10">
                    <div class="flex items-center gap-2 text-xs text-green-400">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>Free cancellation available</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection