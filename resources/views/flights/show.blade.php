@extends('layouts.app')

@section('title', $flight['airline'] . ' ' . $flight['flight_number'] . ' — TripExplorer')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <a href="{{ route('flights.search') }}" class="hover:text-primary-400 transition-colors">Flights</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-white">{{ $flight['flight_number'] }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Flight Header Card -->
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="plane" class="w-7 h-7 text-primary-400"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">{{ $flight['airline'] }}</h1>
                        <div class="text-sm text-gray-400">Flight {{ $flight['flight_number'] }} • {{ $flight['aircraft'] ?? 'N/A' }}</div>
                    </div>
                    @if(isset($flight['original_price']) && $flight['original_price'] > $flight['price'])
                    <div class="ml-auto px-3 py-1 bg-green-500/10 text-green-400 rounded-xl text-sm font-semibold border border-green-500/20">
                        Save ${{ number_format($flight['original_price'] - $flight['price']) }}
                    </div>
                    @endif
                </div>

                <!-- Route Visual Timeline -->
                <div class="flex items-stretch gap-6 py-8">
                    <div class="text-center min-w-[100px]">
                        <div class="text-3xl font-black text-white">{{ $flight['departure_time'] }}</div>
                        <div class="text-lg font-semibold text-primary-400 mt-1">{{ $flight['origin'] }}</div>
                        <div class="text-sm text-gray-400">{{ $flight['origin_city'] }}</div>
                    </div>

                    <div class="flex-1 flex flex-col items-center justify-center relative py-4">
                        <div class="absolute top-0 w-full text-center text-sm font-medium text-gray-400">{{ $flight['duration'] }}</div>
                        <div class="w-full flex items-center">
                            <div class="w-4 h-4 rounded-full bg-primary-500 border-4 border-dark-800 z-10 flex-shrink-0"></div>
                            <div class="flex-1 h-0.5 bg-gradient-to-r from-primary-500 to-accent-500 relative">
                                <i data-lucide="plane" class="w-5 h-5 text-primary-400 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rotate-90 sm:rotate-0"></i>
                            </div>
                            <div class="w-4 h-4 rounded-full bg-accent-500 border-4 border-dark-800 z-10 flex-shrink-0"></div>
                        </div>
                        <div class="absolute bottom-0 w-full text-center">
                            <span class="text-xs {{ $flight['stops'] == 0 ? 'text-green-400' : 'text-yellow-400' }} font-medium">
                                {{ $flight['stops'] == 0 ? '✈ Direct Flight' : $flight['stops'] . ' Stop(s)' }}
                            </span>
                        </div>
                    </div>

                    <div class="text-center min-w-[100px]">
                        <div class="text-3xl font-black text-white">{{ $flight['arrival_time'] }}</div>
                        <div class="text-lg font-semibold text-accent-400 mt-1">{{ $flight['destination'] }}</div>
                        <div class="text-sm text-gray-400">{{ $flight['destination_city'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Flight Details -->
            @if(isset($flight['flight_details']))
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-primary-400"></i> Flight Details
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($flight['flight_details'] as $key => $value)
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-white/5">
                        <i data-lucide="{{ match($key) {
                            'departure_terminal' => 'building',
                            'arrival_terminal' => 'building-2',
                            'meal' => 'utensils',
                            'entertainment' => 'monitor',
                            'wifi' => 'wifi',
                            'power' => 'plug',
                            default => 'circle'
                        } }}" class="w-4 h-4 text-primary-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="text-xs text-gray-400 capitalize">{{ str_replace('_', ' ', $key) }}</div>
                            <div class="text-sm text-white">{{ $value }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Baggage Info -->
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="luggage" class="w-5 h-5 text-primary-400"></i> Baggage Allowance
                </h2>
                <div class="flex items-center gap-3 p-4 rounded-xl bg-white/5">
                    <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="briefcase" class="w-6 h-6 text-primary-400"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">{{ $flight['cabin_class'] }} Class</div>
                        <div class="text-sm text-gray-400">{{ $flight['baggage'] ?? 'Standard baggage allowance' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Price & Booking -->
            <div class="glass rounded-2xl p-6 sticky top-24">
                <div class="text-center mb-6">
                    <div class="text-sm text-gray-400 mb-1">Total fare per person</div>
                    @if(isset($flight['original_price']))
                    <div class="text-sm text-gray-500 line-through">${{ number_format($flight['original_price']) }}</div>
                    @endif
                    <div class="text-3xl font-black text-white">${{ number_format($flight['price']) }}</div>
                    <div class="text-xs text-gray-500">{{ $flight['cabin_class'] }}</div>
                </div>

                <a href="{{ route('booking.create', ['type' => 'flight', 'item_id' => $flight['id'], 'item_name' => $flight['airline'] . ' ' . $flight['flight_number'] . ' (' . $flight['origin'] . ' → ' . $flight['destination'] . ')', 'price' => $flight['price'], 'currency' => $flight['currency']]) }}"
                    class="block w-full py-3.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white text-center font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 hover:shadow-primary-500/40 mb-4">
                    Book This Flight
                </a>

                <div class="flex items-center justify-center gap-2 text-xs text-gray-400">
                    <i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i>
                    Price guarantee
                </div>
            </div>

            <!-- Fare Breakdown -->
            @if(isset($flight['fare_breakdown']))
            <div class="glass rounded-2xl p-6">
                <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="receipt" class="w-4 h-4 text-primary-400"></i> Fare Breakdown
                </h3>
                <div class="space-y-3">
                    @foreach($flight['fare_breakdown'] as $key => $value)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                        <span class="text-sm text-white font-medium">${{ number_format($value, 2) }}</span>
                    </div>
                    @endforeach
                    <div class="border-t border-white/10 pt-3 flex items-center justify-between">
                        <span class="text-sm font-semibold text-white">Total</span>
                        <span class="text-lg font-bold text-white">${{ number_format($flight['price']) }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Info -->
            <div class="glass rounded-2xl p-6">
                <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4 text-primary-400"></i> Quick Info
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <i data-lucide="clock" class="w-4 h-4 text-gray-500"></i>
                        Duration: {{ $flight['duration'] }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <i data-lucide="plane" class="w-4 h-4 text-gray-500"></i>
                        Aircraft: {{ $flight['aircraft'] ?? 'N/A' }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <i data-lucide="armchair" class="w-4 h-4 text-gray-500"></i>
                        Class: {{ $flight['cabin_class'] }}
                    </li>
                    <li class="flex items-center gap-2 text-sm {{ $flight['stops'] == 0 ? 'text-green-400' : 'text-yellow-400' }}">
                        <i data-lucide="git-branch" class="w-4 h-4"></i>
                        {{ $flight['stops'] == 0 ? 'Direct flight' : $flight['stops'] . ' stop(s)' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection