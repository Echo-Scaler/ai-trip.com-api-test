@extends('layouts.app')

@section('title', 'Hotel Search Results — TripExplorer')
@section('meta_description', 'Find the best hotel deals. Search results powered by Trip.com API.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Search Header -->
    <div class="glass rounded-2xl p-6 mb-8">
        <form action="{{ route('hotels.search') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.destination') }}</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="text" name="city" value="{{ $params['city'] ?? '' }}" placeholder="{{ __('messages.city_name_placeholder') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.check_in') }}</label>
                <input type="date" name="check_in" value="{{ $params['check_in'] ?? '' }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.check_out') }}</label>
                <input type="date" name="check_out" value="{{ $params['check_out'] ?? '' }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.guests') }}</label>
                <select name="guests" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all appearance-none">
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ ($params['guests'] ?? 1) == $i ? 'selected' : '' }} class="bg-dark-900">{{ $i }} {{ __('messages.guest') }}{{ $i > 1 ? 's' : '' }}</option>
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
                @if(!empty($params['city']))
                {{ __('messages.hotels_in', ['city' => $params['city']]) }}
                @else
                {{ __('messages.all_hotels') }}
                @endif
            </h1>
            <p class="text-sm text-gray-400 mt-1">{{ count($hotels) }} {{ __('messages.results_found') }}</p>
        </div>
    </div>

    @if(count($hotels) === 0)
    <!-- No Results -->
    <div class="glass rounded-2xl p-12 text-center">
        <i data-lucide="search-x" class="w-12 h-12 text-gray-500 mx-auto mb-4"></i>
        <h3 class="text-lg font-semibold text-white mb-2">{{ __('messages.no_hotels_found') }}</h3>
        <p class="text-gray-400 text-sm">{{ __('messages.try_adjusting') }}</p>
        <a href="{{ route('hotels.search') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-primary-600/20 text-primary-400 rounded-xl text-sm font-medium hover:bg-primary-600/30 transition-colors">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i> {{ __('messages.clear_search') }}
        </a>
    </div>
    @else
    <!-- Hotel Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($hotels as $hotel)
        <a href="{{ route('hotels.show', $hotel['id']) }}" class="glass rounded-2xl overflow-hidden card-hover shine-effect group">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ $hotel['image_url'] }}" alt="{{ $hotel['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 via-transparent to-transparent"></div>
                @if(isset($hotel['original_price']) && $hotel['original_price'] > $hotel['price_per_night'])
                <div class="absolute top-3 left-3 px-2.5 py-1 bg-red-500/90 rounded-lg text-xs font-bold text-white">
                    -{{ round((1 - $hotel['price_per_night'] / $hotel['original_price']) * 100) }}% {{ __('messages.off') }}
                </div>
                @endif
                <div class="absolute top-3 right-3 px-2.5 py-1 glass rounded-lg text-xs font-semibold text-white flex items-center gap-1">
                    <i data-lucide="star" class="w-3 h-3 star-filled fill-current"></i>
                    {{ $hotel['rating'] }}
                </div>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-1 mb-2">
                    @for($i = 0; $i < $hotel['stars']; $i++)
                        <i data-lucide="star" class="w-3 h-3 star-filled fill-current"></i>
                        @endfor
                </div>
                <h3 class="text-lg font-bold text-white mb-1 group-hover:text-primary-400 transition-colors">{{ $hotel['name'] }}</h3>
                <p class="text-sm text-gray-400 flex items-center gap-1 mb-3">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $hotel['address'] }}, {{ $hotel['city'] }}
                </p>
                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach(array_slice($hotel['amenities'], 0, 4) as $amenity)
                    <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-primary-500/10 text-primary-400 border border-primary-500/20">{{ $amenity }}</span>
                    @endforeach
                    @if(count($hotel['amenities']) > 4)
                    <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-white/5 text-gray-400">+{{ count($hotel['amenities']) - 4 }} {{ __('messages.more') }}</span>
                    @endif
                </div>
                <div class="flex items-end justify-between pt-3 border-t border-white/5">
                    <div>
                        @if(isset($hotel['original_price']))
                        <span class="text-xs text-gray-500 line-through">{{ \App\Helpers\CurrencyHelper::format($hotel['original_price']) }}</span>
                        @endif
                        <div class="text-xl font-bold text-white">{{ \App\Helpers\CurrencyHelper::format($hotel['price_per_night']) }}<span class="text-xs font-normal text-gray-400">/{{ __('messages.per_night') }}</span></div>
                    </div>
                    <span class="text-xs text-gray-500">{{ number_format($hotel['review_count'] ?? 0) }} {{ __('messages.reviews') }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection