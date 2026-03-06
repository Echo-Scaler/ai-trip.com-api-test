@extends('layouts.app')

@section('title', 'TripExplorer — Search Hotels & Flights | Trip.com API')
@section('meta_description', 'Explore the world with TripExplorer. Search and book hotels and flights powered by the Trip.com API.')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl float"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-accent-500/8 rounded-full blur-3xl float" style="animation-delay: -3s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-600/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full badge-gradient border border-primary-500/20 mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-400 pulse-dot"></span>
                <span class="text-xs font-medium text-primary-300">Powered by Trip.com API</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white leading-tight mb-6">
                Explore the World
                <span class="block bg-gradient-to-r from-primary-400 via-accent-400 to-primary-400 bg-clip-text text-transparent">with Confidence</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                Search and book hotels & flights worldwide. Real-time data from Trip.com's global travel network.
            </p>

            <!-- Search Tabs -->
            <div class="glass rounded-2xl p-2 max-w-3xl mx-auto">
                <div class="flex gap-1 mb-4">
                    <button id="tab-hotels" onclick="switchTab('hotels')" class="flex-1 flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-sm font-semibold transition-all bg-primary-600 text-white shadow-lg shadow-primary-600/25">
                        <i data-lucide="building-2" class="w-4 h-4"></i> Hotels
                    </button>
                    <button id="tab-flights" onclick="switchTab('flights')" class="flex-1 flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-sm font-semibold transition-all text-gray-400 hover:text-white hover:bg-white/5">
                        <i data-lucide="plane" class="w-4 h-4"></i> Flights
                    </button>
                </div>

                <!-- Hotel Search Form -->
                <form id="form-hotels" action="{{ route('hotels.search') }}" method="GET" class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Destination</label>
                            <div class="relative">
                                <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                <input type="text" name="city" placeholder="Tokyo, Singapore..." class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Check-in</label>
                            <div class="relative">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                <input type="date" name="check_in" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Check-out</label>
                            <div class="relative">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                <input type="date" name="check_out" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                            </div>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 hover:shadow-primary-500/40 flex items-center justify-center gap-2">
                                <i data-lucide="search" class="w-4 h-4"></i> Search
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Flight Search Form -->
                <form id="form-flights" action="{{ route('flights.search') }}" method="GET" class="p-4 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">From</label>
                            <div class="relative">
                                <i data-lucide="plane-takeoff" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                <input type="text" name="origin" placeholder="NRT, Tokyo..." class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">To</label>
                            <div class="relative">
                                <i data-lucide="plane-landing" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                <input type="text" name="destination" placeholder="SIN, Singapore..." class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">Departure</label>
                            <div class="relative">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                                <input type="date" name="departure_date" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                            </div>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 hover:shadow-primary-500/40 flex items-center justify-center gap-2">
                                <i data-lucide="search" class="w-4 h-4"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Featured Hotels -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Featured Hotels</h2>
            <p class="text-gray-400 mt-1">Top-rated accommodations from Trip.com</p>
        </div>
        <a href="{{ route('hotels.search') }}" class="hidden sm:flex items-center gap-2 text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors">
            View all <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($featuredHotels as $hotel)
        <a href="{{ route('hotels.show', $hotel['id']) }}" class="glass rounded-2xl overflow-hidden card-hover shine-effect group">
            <div class="relative h-52 overflow-hidden">
                <img src="{{ $hotel['image_url'] }}" alt="{{ $hotel['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 via-transparent to-transparent"></div>
                @if(isset($hotel['original_price']) && $hotel['original_price'] > $hotel['price_per_night'])
                <div class="absolute top-3 left-3 px-2.5 py-1 bg-red-500/90 rounded-lg text-xs font-bold text-white">
                    -{{ round((1 - $hotel['price_per_night'] / $hotel['original_price']) * 100) }}%
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
                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $hotel['city'] }}
                </p>
                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach(array_slice($hotel['amenities'], 0, 3) as $amenity)
                    <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-primary-500/10 text-primary-400 border border-primary-500/20">{{ $amenity }}</span>
                    @endforeach
                </div>
                <div class="flex items-end justify-between pt-3 border-t border-white/5">
                    <div>
                        @if(isset($hotel['original_price']))
                        <span class="text-xs text-gray-500 line-through">${{ number_format($hotel['original_price']) }}</span>
                        @endif
                        <div class="text-xl font-bold text-white">${{ number_format($hotel['price_per_night']) }}<span class="text-xs font-normal text-gray-400">/night</span></div>
                    </div>
                    <span class="text-xs text-gray-500">{{ number_format($hotel['review_count'] ?? 0) }} reviews</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

<!-- Featured Flights -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Popular Flights</h2>
            <p class="text-gray-400 mt-1">Best deals on popular routes</p>
        </div>
        <a href="{{ route('flights.search') }}" class="hidden sm:flex items-center gap-2 text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors">
            View all <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        @foreach($featuredFlights as $flight)
        <a href="{{ route('flights.show', $flight['id']) }}" class="glass rounded-2xl p-5 card-hover shine-effect group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-bold text-white">{{ $flight['airline'] }}</span>
                <span class="text-xs text-gray-500">{{ $flight['flight_number'] }}</span>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ $flight['departure_time'] }}</div>
                    <div class="text-xs text-gray-400">{{ $flight['origin'] }}</div>
                </div>
                <div class="flex-1 flex items-center gap-1">
                    <div class="h-px flex-1 bg-gradient-to-r from-primary-500 to-transparent"></div>
                    <div class="px-2 py-0.5 rounded-md text-[10px] font-medium text-gray-400 bg-white/5">{{ $flight['duration'] }}</div>
                    <div class="h-px flex-1 bg-gradient-to-l from-primary-500 to-transparent"></div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ $flight['arrival_time'] }}</div>
                    <div class="text-xs text-gray-400">{{ $flight['destination'] }}</div>
                </div>
            </div>
            <div class="flex items-center justify-between pt-3 border-t border-white/5">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">{{ $flight['stops'] == 0 ? 'Direct' : $flight['stops'] . ' stop(s)' }}</span>
                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                    <span class="text-xs text-gray-500">{{ $flight['cabin_class'] }}</span>
                </div>
                <div>
                    @if(isset($flight['original_price']))
                    <span class="text-xs text-gray-500 line-through mr-1">${{ number_format($flight['original_price']) }}</span>
                    @endif
                    <span class="text-lg font-bold text-white">${{ number_format($flight['price']) }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

<!-- API Integration Info -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="glass rounded-2xl p-8 md:p-12 text-center">
        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary-500/25">
            <i data-lucide="code-2" class="w-8 h-8 text-white"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-3">Real-World API Architecture</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-8">
            This app demonstrates a production-ready Trip.com API integration pattern with Laravel.
            Interface-based services, DTOs, and a swappable mock data layer.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto">
            <div class="glass-light rounded-xl p-4">
                <i data-lucide="layers" class="w-6 h-6 text-primary-400 mx-auto mb-2"></i>
                <div class="text-sm font-semibold text-white">Service Layer</div>
                <div class="text-xs text-gray-400 mt-1">Contract + Mock/Real</div>
            </div>
            <div class="glass-light rounded-xl p-4">
                <i data-lucide="database" class="w-6 h-6 text-accent-400 mx-auto mb-2"></i>
                <div class="text-sm font-semibold text-white">DTOs</div>
                <div class="text-xs text-gray-400 mt-1">Type-safe data transfer</div>
            </div>
            <div class="glass-light rounded-xl p-4">
                <i data-lucide="shield-check" class="w-6 h-6 text-green-400 mx-auto mb-2"></i>
                <div class="text-sm font-semibold text-white">HMAC Auth</div>
                <div class="text-xs text-gray-400 mt-1">Secure API signing</div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function switchTab(tab) {
        const hotelTab = document.getElementById('tab-hotels');
        const flightTab = document.getElementById('tab-flights');
        const hotelForm = document.getElementById('form-hotels');
        const flightForm = document.getElementById('form-flights');

        if (tab === 'hotels') {
            hotelTab.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-sm font-semibold transition-all bg-primary-600 text-white shadow-lg shadow-primary-600/25';
            flightTab.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-sm font-semibold transition-all text-gray-400 hover:text-white hover:bg-white/5';
            hotelForm.classList.remove('hidden');
            flightForm.classList.add('hidden');
        } else {
            flightTab.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-sm font-semibold transition-all bg-primary-600 text-white shadow-lg shadow-primary-600/25';
            hotelTab.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-sm font-semibold transition-all text-gray-400 hover:text-white hover:bg-white/5';
            flightForm.classList.remove('hidden');
            hotelForm.classList.add('hidden');
        }
        lucide.createIcons();
    }
</script>
@endsection