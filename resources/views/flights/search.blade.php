@extends('layouts.app')

@section('title', 'Flight Search Results — TripExplorer')
@section('meta_description', 'Find the best flight deals. Search results powered by Trip.com API.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Search Header -->
    <div class="glass rounded-2xl p-6 mb-8">
        <form action="{{ route('flights.search') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.from') }}</label>
                <div class="relative">
                    <i data-lucide="plane-takeoff" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="text" name="origin" value="{{ $params['origin'] ?? '' }}" placeholder="{{ __('messages.origin_placeholder') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.to') }}</label>
                <div class="relative">
                    <i data-lucide="plane-landing" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="text" name="destination" value="{{ $params['destination'] ?? '' }}" placeholder="{{ __('messages.destination_placeholder') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.departure_date') }}</label>
                <input type="date" name="departure_date" value="{{ $params['departure_date'] ?? '' }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.passengers') }}</label>
                <select name="passengers" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all appearance-none">
                    @for($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}" {{ ($params['passengers'] ?? 1) == $i ? 'selected' : '' }} class="bg-dark-900">{{ $i }} {{ __('messages.passenger') }}{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                </select>
            </div>
            <button type="submit" class="py-3 px-6 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 flex items-center justify-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i> {{ __('messages.search') }}
            </button>
        </form>
    </div>

    <!-- Results Count -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">
                @if(!empty($params['origin']) && !empty($params['destination']))
                {{ __('messages.flights_from_to', ['origin' => $params['origin'], 'destination' => $params['destination']]) }}
                @elseif(!empty($params['origin']))
                {{ __('messages.flights_from', ['origin' => $params['origin']]) }}
                @elseif(!empty($params['destination']))
                {{ __('messages.flights_to', ['destination' => $params['destination']]) }}
                @else
                {{ __('messages.all_flights') }}
                @endif
            </h1>
            <p class="text-sm text-gray-400 mt-1">{{ $flights->total() }} {{ __('messages.results_found') }}</p>
        </div>
    </div>

    @if($flights->isEmpty())
    <div class="glass rounded-2xl p-12 text-center">
        <i data-lucide="search-x" class="w-12 h-12 text-gray-500 mx-auto mb-4"></i>
        <h3 class="text-lg font-semibold text-white mb-2">{{ __('messages.no_flights_found') }}</h3>
        <p class="text-gray-400 text-sm">{{ __('messages.try_adjusting_flights') }}</p>
        <a href="{{ route('flights.search') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-primary-600/20 text-primary-400 rounded-xl text-sm font-medium hover:bg-primary-600/30 transition-colors">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i> {{ __('messages.clear_search') }}
        </a>
    </div>
    @else
    <!-- Flight Cards -->
    <div class="space-y-4">
        @foreach($flights as $flight)
        <a href="{{ route('flights.show', $flight['id']) }}" class="glass rounded-2xl p-6 block card-hover shine-effect group">
            <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                <!-- Airline Info -->
                <div class="flex items-center gap-3 lg:w-48 flex-shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="plane" class="w-5 h-5 text-primary-400"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">{{ $flight['airline'] }}</div>
                        <div class="text-xs text-gray-500">{{ $flight['flight_number'] }}</div>
                    </div>
                </div>

                <!-- Route Timeline -->
                <div class="flex-1 flex items-center gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $flight['departure_time'] }}</div>
                        <div class="text-sm text-gray-400">{{ $flight['origin'] }}</div>
                        <div class="text-xs text-gray-500">{{ $flight['origin_city'] }}, {{ $flight['origin_country'] }}</div>
                    </div>

                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="text-xs text-gray-500">{{ $flight['duration'] }}</div>
                        <div class="w-full flex items-center gap-1">
                            <div class="w-2 h-2 rounded-full bg-primary-500"></div>
                            <div class="flex-1 h-px bg-gradient-to-r from-primary-500 via-primary-400 to-primary-500 relative">
                                @if($flight['stops'] > 0)
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-yellow-400"></div>
                                @endif
                            </div>
                            <div class="w-2 h-2 rounded-full bg-primary-500"></div>
                        </div>
                        <div class="text-xs {{ $flight['stops'] == 0 ? 'text-green-400' : 'text-yellow-400' }}">
                            {{ $flight['stops'] == 0 ? __('messages.direct') : $flight['stops'] . ' ' . __('messages.stops') }}
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $flight['arrival_time'] }}</div>
                        <div class="text-sm text-gray-400">{{ $flight['destination'] }}</div>
                        <div class="text-xs text-gray-500">{{ $flight['destination_city'] }}, {{ $flight['destination_country'] }}</div>
                    </div>
                </div>

                <!-- Price & Book -->
                <div class="lg:w-44 flex-shrink-0 text-right flex lg:flex-col items-center lg:items-end justify-between lg:justify-center gap-2">
                    <div>
                        @if(isset($flight['original_price']))
                        <div class="text-xs text-gray-500 line-through">{{ \App\Helpers\CurrencyHelper::format($flight['original_price']) }}</div>
                        @endif
                        <div class="text-2xl font-bold text-white">{{ \App\Helpers\CurrencyHelper::format($flight['price']) }}</div>
                        <div class="text-xs text-gray-500">{{ $flight['cabin_class'] }}</div>
                    </div>
                    <span class="px-5 py-2 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-sm font-semibold rounded-xl group-hover:from-primary-500 group-hover:to-primary-400 transition-all">
                        {{ __('messages.view_deal') }}
                    </span>
                </div>
            </div>

            <!-- Extra Info -->
            <div class="flex flex-wrap items-center gap-4 mt-4 pt-4 border-t border-white/5 text-xs text-gray-500">
                @if(isset($flight['aircraft']))
                <span class="flex items-center gap-1"><i data-lucide="plane" class="w-3 h-3"></i> {{ $flight['aircraft'] }}</span>
                @endif
                @if(isset($flight['baggage']))
                <span class="flex items-center gap-1"><i data-lucide="luggage" class="w-3 h-3"></i> {{ $flight['baggage'] }}</span>
                @endif
                @if(isset($flight['original_price']) && $flight['original_price'] > $flight['price'])
                <span class="flex items-center gap-1 text-green-400"><i data-lucide="tag" class="w-3 h-3"></i> {{ __('messages.save') }} {{ \App\Helpers\CurrencyHelper::format($flight['original_price'] - $flight['price']) }}</span>
                @endif
            </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-8 flex justify-between items-center bg-white/5 border border-white/10 rounded-2xl p-4">
        {{ $flights->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection