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

<!-- Promotional Ad Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-8">
    <a href="#" class="block relative glass rounded-2xl overflow-hidden card-hover shine-effect group">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=1200&q=80" alt="Car Rental Ad" class="w-full h-full object-cover opacity-40 group-hover:opacity-50 transition-opacity duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-dark-950/90 via-dark-950/70 to-transparent"></div>
        </div>
        <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex-1">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 text-gray-300 text-[10px] font-bold uppercase tracking-wider mb-4 border border-white/10 backdrop-blur-md">
                    <i data-lucide="megaphone" class="w-3 h-3 text-primary-400"></i> Sponsored
                </div>
                <h3 class="text-2xl sm:text-3xl font-black text-white mb-2 group-hover:text-primary-400 transition-colors">Hit the Road in Style</h3>
                <p class="text-sm text-gray-400 max-w-lg">Unlock up to 30% off premium car rentals worldwide. Book your dream ride today and explore without limits.</p>
            </div>
            <div class="shrink-0 w-full sm:w-auto">
                <div class="px-6 py-3 bg-white text-dark-950 font-bold rounded-xl text-center flex items-center justify-center gap-2 group-hover:bg-gradient-to-r group-hover:from-primary-600 group-hover:to-primary-500 group-hover:text-white transition-all shadow-lg shadow-white/10 group-hover:shadow-primary-500/25">
                    Claim Offer <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </div>
        </div>
    </a>
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

<!-- Promotional Ad Banner 2 -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <a href="#" class="block relative glass rounded-2xl overflow-hidden card-hover shine-effect group">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1518104593124-ac2e82a5eb9b?w=1200&q=80" alt="Travel Insurance Ad" class="w-full h-full object-cover opacity-40 group-hover:opacity-50 transition-opacity duration-500">
            <div class="absolute inset-0 bg-gradient-to-r from-dark-950/90 via-dark-950/70 to-transparent"></div>
        </div>
        <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex-1">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 text-gray-300 text-[10px] font-bold uppercase tracking-wider mb-4 border border-white/10 backdrop-blur-md">
                    <i data-lucide="shield-check" class="w-3 h-3 text-red-400"></i> Sponsored
                </div>
                <h3 class="text-2xl sm:text-3xl font-black text-white mb-2 group-hover:text-red-400 transition-colors">Travel Worry-Free</h3>
                <p class="text-sm text-gray-400 max-w-lg">Get comprehensive travel insurance starting at just $5/day. Protect your trip globally against cancellations, medical emergencies, and lost baggage.</p>
            </div>
            <div class="shrink-0 w-full sm:w-auto">
                <div class="px-6 py-3 bg-white text-dark-950 font-bold rounded-xl text-center flex items-center justify-center gap-2 group-hover:bg-gradient-to-r group-hover:from-red-600 group-hover:to-red-500 group-hover:text-white transition-all shadow-lg shadow-white/10 group-hover:shadow-red-500/25">
                    View Plans <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </div>
        </div>
    </a>
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

<!-- Exclusive Coupons -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Exclusive Coupons</h2>
            <p class="text-gray-400 mt-1">Grab these deals before they expire</p>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-sm font-medium text-primary-400">
            <i data-lucide="timer" class="w-4 h-4"></i> Limited Time
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Coupon 1 -->
        <div class="relative glass rounded-2xl overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500"></div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500/20 to-orange-500/20 flex items-center justify-center">
                        <i data-lucide="tag" class="w-6 h-6 text-yellow-400"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-black text-white">20<span class="text-lg">%</span></div>
                        <div class="text-xs text-yellow-400 font-bold uppercase">Off</div>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-white mb-1">First Hotel Booking</h3>
                <p class="text-sm text-gray-400 mb-4">Save 20% on your first hotel reservation. Valid for all destinations.</p>
                <div class="flex items-center justify-between pt-4 border-t border-dashed border-white/10">
                    <code class="px-3 py-1.5 rounded-lg bg-yellow-500/10 text-yellow-400 text-sm font-mono font-bold tracking-wider">FIRST20</code>
                    <span class="text-xs text-gray-500">Expires Apr 30</span>
                </div>
            </div>
        </div>

        <!-- Coupon 2 -->
        <div class="relative glass rounded-2xl overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-400 via-primary-500 to-indigo-500"></div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-primary-500/20 flex items-center justify-center">
                        <i data-lucide="plane" class="w-6 h-6 text-blue-400"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-black text-white">$50</div>
                        <div class="text-xs text-blue-400 font-bold uppercase">Off</div>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-white mb-1">Flights Over $300</h3>
                <p class="text-sm text-gray-400 mb-4">Get $50 off any flight booking over $300. All airlines included.</p>
                <div class="flex items-center justify-between pt-4 border-t border-dashed border-white/10">
                    <code class="px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-400 text-sm font-mono font-bold tracking-wider">FLY50NOW</code>
                    <span class="text-xs text-gray-500">Expires May 15</span>
                </div>
            </div>
        </div>

        <!-- Coupon 3 -->
        <div class="relative glass rounded-2xl overflow-hidden group">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-500"></div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500/20 to-emerald-500/20 flex items-center justify-center">
                        <i data-lucide="gift" class="w-6 h-6 text-green-400"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-black text-white">15<span class="text-lg">%</span></div>
                        <div class="text-xs text-green-400 font-bold uppercase">Off</div>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-white mb-1">Bundle & Save</h3>
                <p class="text-sm text-gray-400 mb-4">Book hotel + flight together and save 15% on the total package.</p>
                <div class="flex items-center justify-between pt-4 border-t border-dashed border-white/10">
                    <code class="px-3 py-1.5 rounded-lg bg-green-500/10 text-green-400 text-sm font-mono font-bold tracking-wider">BUNDLE15</code>
                    <span class="text-xs text-gray-500">Expires Jun 01</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Promotional Ad Banner 3 -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <a href="#" class="block relative glass rounded-2xl overflow-hidden card-hover shine-effect group">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1520694478166-da20fd58ee42?w=1200&q=80" alt="Global eSIM Ad" class="w-full h-full object-cover opacity-40 group-hover:opacity-50 transition-opacity duration-500">
            <div class="absolute inset-0 bg-gradient-to-l from-dark-950/90 via-dark-950/70 to-transparent"></div>
        </div>
        <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="shrink-0 w-full sm:w-auto sm:order-2">
                <div class="px-6 py-3 bg-white text-dark-950 font-bold rounded-xl text-center flex items-center justify-center gap-2 group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-purple-500 group-hover:text-white transition-all shadow-lg shadow-white/10 group-hover:shadow-purple-500/25">
                    Buy Data <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="flex-1 sm:order-1 sm:text-right">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 text-gray-300 text-[10px] font-bold uppercase tracking-wider mb-4 border border-white/10 backdrop-blur-md">
                    <i data-lucide="wifi" class="w-3 h-3 text-purple-400"></i> Sponsored
                </div>
                <div class="flex flex-col sm:items-end w-full">
                    <h3 class="text-2xl sm:text-3xl font-black text-white mb-2 group-hover:text-purple-400 transition-colors">Stay Connected Anywhere</h3>
                    <p class="text-sm text-gray-400 max-w-lg">Instantly activate a Global eSIM on your phone. Enjoy high-speed 5G data in over 150+ countries with zero roaming fees.</p>
                </div>
            </div>
        </div>
    </a>
</section>

<!-- Trip Packages -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Curated Trip Packages</h2>
            <p class="text-gray-400 mt-1">All-inclusive plans crafted by travel experts</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Package 1: Japan Explorer -->
        <div class="relative glass rounded-2xl overflow-hidden card-hover shine-effect group">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=800&q=80" alt="Japan" class="w-full h-full object-cover opacity-30 group-hover:opacity-40 transition-opacity duration-500">
                <div class="absolute inset-0 bg-gradient-to-r from-dark-950 via-dark-950/90 to-dark-950/60"></div>
            </div>
            <div class="relative p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold mb-3">
                            <i data-lucide="flame" class="w-3 h-3"></i> Best Seller
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-1">Japan Explorer</h3>
                        <p class="text-sm text-gray-400">7 Days · Tokyo → Kyoto → Osaka</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 line-through">$2,899</div>
                        <div class="text-3xl font-black text-white">$1,999</div>
                        <div class="text-xs text-green-400 font-semibold">Save $900</div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="plane" class="w-3 h-3"></i> Round-trip</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="building-2" class="w-3 h-3"></i> 4★ Hotels</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="utensils" class="w-3 h-3"></i> Breakfast</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="map" class="w-3 h-3"></i> Guided Tours</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="train-front" class="w-3 h-3"></i> JR Pass</span>
                </div>
                <a href="{{ route('hotels.search', ['city' => 'Tokyo']) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 text-sm">
                    View Package <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <!-- Package 2: Southeast Asia Circuit -->
        <div class="relative glass rounded-2xl overflow-hidden card-hover shine-effect group">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1506665531195-3566af2b4dfa?w=800&q=80" alt="Bali" class="w-full h-full object-cover opacity-30 group-hover:opacity-40 transition-opacity duration-500">
                <div class="absolute inset-0 bg-gradient-to-r from-dark-950 via-dark-950/90 to-dark-950/60"></div>
            </div>
            <div class="relative p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-400 text-xs font-bold mb-3">
                            <i data-lucide="sparkles" class="w-3 h-3"></i> New Package
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-1">Southeast Asia Circuit</h3>
                        <p class="text-sm text-gray-400">10 Days · Singapore → Bangkok → Bali</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 line-through">$3,499</div>
                        <div class="text-3xl font-black text-white">$2,499</div>
                        <div class="text-xs text-green-400 font-semibold">Save $1,000</div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="plane" class="w-3 h-3"></i> Multi-city</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="building-2" class="w-3 h-3"></i> 5★ Resorts</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="utensils" class="w-3 h-3"></i> Half Board</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="waves" class="w-3 h-3"></i> Beach Access</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="car" class="w-3 h-3"></i> Transfers</span>
                </div>
                <a href="{{ route('hotels.search', ['city' => 'Singapore']) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 text-sm">
                    View Package <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <!-- Package 3: Korea Highlights -->
        <div class="relative glass rounded-2xl overflow-hidden card-hover shine-effect group">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1517154421773-0529f29ea451?w=800&q=80" alt="Seoul" class="w-full h-full object-cover opacity-30 group-hover:opacity-40 transition-opacity duration-500">
                <div class="absolute inset-0 bg-gradient-to-r from-dark-950 via-dark-950/90 to-dark-950/60"></div>
            </div>
            <div class="relative p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs font-bold mb-3">
                            <i data-lucide="trending-up" class="w-3 h-3"></i> Trending
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-1">Korea Highlights</h3>
                        <p class="text-sm text-gray-400">5 Days · Seoul → Busan</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 line-through">$1,599</div>
                        <div class="text-3xl font-black text-white">$1,199</div>
                        <div class="text-xs text-green-400 font-semibold">Save $400</div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="plane" class="w-3 h-3"></i> Round-trip</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="building-2" class="w-3 h-3"></i> Boutique Hotels</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="utensils" class="w-3 h-3"></i> Food Tour</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 text-xs text-gray-300 flex items-center gap-1"><i data-lucide="train-front" class="w-3 h-3"></i> KTX Pass</span>
                </div>
                <a href="{{ route('hotels.search', ['city' => 'Seoul']) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 text-sm">
                    View Package <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <!-- Newsletter / CTA -->
        <div class="glass rounded-2xl p-8 flex flex-col justify-center">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center mb-5 shadow-lg shadow-primary-500/25">
                <i data-lucide="bell-ring" class="w-7 h-7 text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Get Exclusive Deals</h3>
            <p class="text-sm text-gray-400 mb-6">Subscribe to receive personalized trip packages and flash sale alerts straight to your inbox.</p>
            <div class="flex gap-2">
                <input type="email" placeholder="your@email.com" class="flex-1 bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all">
                <button class="px-5 py-3 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 flex-shrink-0">
                    <i data-lucide="send" class="w-4 h-4"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-3">No spam. Unsubscribe anytime.</p>
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