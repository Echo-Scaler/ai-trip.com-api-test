@extends('layouts.app')

@section('title', $hotel['name'] . ' — TripExplorer')
@section('meta_description', $hotel['description'])

@section('content')
@php $hotelData = $hotel; @endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <nav class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">{{ __('messages.home') }}</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="{{ route('hotels.search') }}" class="hover:text-primary-400 transition-colors">{{ __('messages.hotels') }}</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-white">{{ $hotel['name'] }}</span>
        </nav>

        @if(session('success'))
        <div class="bg-green-500/20 text-green-400 border border-green-500/30 px-4 py-2 rounded-xl text-sm flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            {{ session('success') }}
        </div>
        @endif
    </div>

    <!-- Hotel Hero -->
    <div class="glass rounded-2xl overflow-hidden mb-8">
        <div class="relative h-64 sm:h-80 lg:h-96">
            <img src="{{ $hotel['image_url'] }}" alt="{{ $hotel['name'] }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-dark-950 via-dark-950/30 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                <div class="flex items-center gap-1 mb-2">
                    @for($i = 0; $i < $hotel['stars']; $i++)
                        <i data-lucide="star" class="w-4 h-4 star-filled fill-current"></i>
                        @endfor
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white mb-2">{{ $hotel['name'] }}</h1>
                <p class="text-gray-300 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4"></i> {{ $hotel['address'] }}, {{ $hotel['city'] }}
                </p>
            </div>
            <div class="absolute top-4 right-4 flex items-center gap-3">
                <div class="px-3 py-1.5 glass rounded-xl text-sm font-bold text-white flex items-center gap-1.5">
                    <i data-lucide="star" class="w-4 h-4 star-filled fill-current"></i> {{ $hotel['rating'] }}/5
                </div>
                @if(isset($hotel['original_price']) && $hotel['original_price'] > $hotel['price_per_night'])
                <div class="px-3 py-1.5 bg-red-500/90 rounded-xl text-sm font-bold text-white">
                    {{ __('messages.save') }} {{ round((1 - $hotel['price_per_night'] / $hotel['original_price']) * 100) }}%
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-primary-400"></i> {{ __('messages.about_hotel') }}
                </h2>
                <p class="text-gray-300 leading-relaxed">{{ $hotel['description'] }}</p>
            </div>

            <!-- Gallery -->
            @if(isset($hotel['gallery']))
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="image" class="w-5 h-5 text-primary-400"></i> {{ __('messages.gallery') ?? 'Gallery' }}
                </h2>
                <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide snap-x">
                    @foreach($hotel['gallery'] as $img)
                    <div class="flex-shrink-0 w-64 h-44 rounded-xl overflow-hidden border border-white/10 snap-center">
                        <img src="{{ $img }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Amenities -->
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-primary-400"></i> {{ __('messages.amenities') }}
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($hotel['amenities'] as $amenity)
                    <div class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-white/5">
                        <i data-lucide="check-circle" class="w-4 h-4 text-green-400 flex-shrink-0"></i>
                        <span class="text-sm text-gray-300">{{ $amenity }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Map / Location -->
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="map" class="w-5 h-5 text-primary-400"></i> {{ __('messages.location') }}
                </h2>
                <div id="hotel-map" class="h-64 w-full rounded-xl overflow-hidden border border-white/10 z-0"></div>
                <p class="text-sm text-gray-400 mt-3 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-gray-500"></i> {{ $hotel['address'] }}, {{ $hotel['city'] }}, {{ $hotel['country'] }}
                </p>
            </div>

            <!-- Room Options -->
            @if(isset($hotel['rooms']))
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="bed-double" class="w-5 h-5 text-primary-400"></i> {{ __('messages.available_rooms') }}
                </h2>
                <div class="space-y-4">
                    @foreach($hotel['rooms'] as $room)
                    <div class="glass-light rounded-xl p-0 overflow-hidden hover:bg-white/10 transition-colors">
                        <div class="flex flex-col md:flex-row">
                            @if(isset($room['image_url']))
                            <div class="w-full md:w-48 h-48 md:h-auto flex-shrink-0">
                                <img src="{{ $room['image_url'] }}" alt="{{ $room['name'] }}" class="w-full h-full object-cover">
                            </div>
                            @endif
                            <div class="flex-1 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-white mb-2">{{ $room['name'] }}</h3>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                                        <span class="flex items-center gap-1"><i data-lucide="bed" class="w-3.5 h-3.5"></i> {{ $room['bed_type'] }}</span>
                                        <span class="flex items-center gap-1"><i data-lucide="maximize-2" class="w-3.5 h-3.5"></i> {{ $room['size'] }}</span>
                                        <span class="flex items-center gap-1"><i data-lucide="users" class="w-3.5 h-3.5"></i> Max {{ $room['max_guests'] }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1.5 mt-3">
                                        @foreach($room['includes'] as $inc)
                                        <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-green-500/10 text-green-400 border border-green-500/20">{{ $inc }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div class="text-2xl font-bold text-white">{{ \App\Helpers\CurrencyHelper::format($room['price']) }}</div>
                                    <div class="text-xs text-gray-400 mb-3">{{ __('messages.per_night') }}</div>
                                    <a href="{{ route('booking.create', ['type' => 'hotel', 'item_id' => $hotel['id'], 'item_name' => $hotel['name'] . ' — ' . $room['name'], 'price' => $room['price'], 'currency' => $hotel['currency']]) }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25">
                                        {{ __('messages.book_now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Policies -->
            @if(isset($hotel['policies']))
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-primary-400"></i> {{ __('messages.hotel_policies') }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="log-in" class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="text-sm font-medium text-white">{{ __('messages.check_in') }}</div>
                            <div class="text-sm text-gray-400">{{ $hotel['policies']['check_in'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="log-out" class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="text-sm font-medium text-white">{{ __('messages.check_out') }}</div>
                            <div class="text-sm text-gray-400">{{ $hotel['policies']['check_out'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="x-circle" class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="text-sm font-medium text-white">Cancellation</div>
                            <div class="text-sm text-gray-400">{{ $hotel['policies']['cancellation'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="baby" class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="text-sm font-medium text-white">Children</div>
                            <div class="text-sm text-gray-400">{{ $hotel['policies']['children'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Guest Reviews Section -->
            <div class="glass rounded-2xl p-6 mt-8">
                <h2 class="text-xl font-black text-white mb-6 flex items-center gap-2">
                    <i data-lucide="messages-square" class="w-6 h-6 text-primary-400"></i> {{ __('messages.guest_reviews') }}
                </h2>

                @if((isset($reviews) && $reviews->isNotEmpty()) || (isset($hotel['reviews']) && count($hotel['reviews']) > 0))
                <div class="space-y-6 mb-8">
                    {{-- Display Database Reviews First --}}
                    @if(isset($reviews))
                    @foreach($reviews as $review)
                    <div class="border-b border-white/5 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-bold text-white">{{ $review->user_name }}</div>
                            <div class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="flex items-center gap-0.5 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'star-filled fill-current' : 'text-gray-600' }}"></i>
                                @endfor
                        </div>
                        <p class="text-sm text-gray-300">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                    @endif

                    {{-- Display Mock Reviews if no DB reviews or as secondary --}}
                    @if(isset($hotel['reviews']))
                    @foreach($hotel['reviews'] as $mockReview)
                    <div class="border-b border-white/5 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-bold text-white">{{ $mockReview['user'] }}</div>
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($mockReview['date'])->diffForHumans() }}</div>
                        </div>
                        <div class="flex items-center gap-0.5 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $mockReview['rating'] ? 'star-filled fill-current' : 'text-gray-600' }}"></i>
                                @endfor
                        </div>
                        <p class="text-sm text-gray-300">{{ $mockReview['comment'] }}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
                @else
                <div class="text-center py-8 glass-light rounded-xl border border-dashed border-white/10 mb-8">
                    <i data-lucide="message-circle" class="w-10 h-10 text-gray-500 mx-auto mb-3"></i>
                    <h3 class="text-white font-bold mb-1">{{ __('messages.no_reviews_yet') }}</h3>
                    <p class="text-sm text-gray-400">{{ __('messages.no_reviews_yet_desc') }}</p>
                </div>
                @endif

                <!-- Write a Review Form -->
                <div class="glass-light rounded-xl p-6 border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-4">{{ __('messages.write_review') }}</h3>
                    <form action="{{ route('reviews.store', $hotel['id']) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">{{ __('messages.your_name') }}</label>
                            <input type="text" name="user_name" required class="w-full bg-dark-900 border border-white/10 rounded-xl py-2.5 px-4 text-white focus:outline-none focus:border-primary-500 transition-colors" placeholder="John Doe">
                            @error('user_name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('messages.rating') }}</label>
                            <input type="hidden" name="rating" id="rating-input" value="5">
                            <div class="flex items-center gap-1 cursor-pointer" id="star-selector">
                                @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" data-value="{{ $i }}" class="w-6 h-6 star-select star-filled fill-current transition-colors"></i>
                                    @endfor
                            </div>
                            @error('rating') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">{{ __('messages.your_review') }}</label>
                            <textarea name="comment" required rows="3" class="w-full bg-dark-900 border border-white/10 rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-500 transition-colors" placeholder="{{ __('messages.your_review_placeholder') }}"></textarea>
                            @error('comment') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25">
                            {{ __('messages.post_review') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Price Card -->
            <div class="glass rounded-2xl p-6 sticky top-24">
                <div class="text-center mb-6">
                    <div class="text-sm text-gray-400 mb-1">{{ __('messages.starting_from') }}</div>
                    @if(isset($hotel['original_price']))
                    <div class="text-sm text-gray-500 line-through">{{ \App\Helpers\CurrencyHelper::format($hotel['original_price']) }}</div>
                    @endif
                    <div class="text-3xl font-black text-white">{{ \App\Helpers\CurrencyHelper::format($hotel['price_per_night']) }}<span class="text-base font-normal text-gray-400">/{{ __('messages.per_night') }}</span></div>
                </div>
                <a href="{{ route('booking.create', ['type' => 'hotel', 'item_id' => $hotel['id'], 'item_name' => $hotel['name'], 'price' => $hotel['price_per_night'], 'currency' => $hotel['currency']]) }}"
                    class="block w-full py-3.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white text-center font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 hover:shadow-primary-500/40">
                    {{ __('messages.book_now') }}
                </a>
                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i>
                    {{ __('messages.free_cancellation') }}
                </div>
            </div>

            <!-- Nearby -->
            @if(isset($hotel['nearby']))
            <div class="glass rounded-2xl p-6">
                <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="compass" class="w-4 h-4 text-primary-400"></i> {{ __('messages.nearby') }}
                </h3>
                <ul class="space-y-2.5">
                    @foreach($hotel['nearby'] as $place)
                    <li class="text-sm text-gray-400 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-500 flex-shrink-0"></i>
                        {{ $place }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Reviews summary -->
            <div class="glass rounded-2xl p-6">
                <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-4 h-4 text-primary-400"></i> {{ __('messages.guest_reviews') }}
                </h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="text-3xl font-black text-white">{{ $hotel['rating'] }}</div>
                    <div>
                        <div class="flex items-center gap-0.5">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="w-4 h-4 {{ $i < round($hotel['rating']) ? 'star-filled fill-current' : 'text-gray-600' }}"></i>
                                @endfor
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ number_format($hotel['review_count'] ?? 0) }} {{ __('messages.reviews') }}</div>
                    </div>
                </div>
                <div class="text-sm text-gray-400">
                    @if($hotel['rating'] >= 4.5) {{ __('messages.exceptional') }}
                    @elseif($hotel['rating'] >= 4.0) {{ __('messages.excellent') }}
                    @elseif($hotel['rating'] >= 3.5) {{ __('messages.very_good') }}
                    @else {{ __('messages.good') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Star Rating Logic
        const stars = document.querySelectorAll('.star-select');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const val = parseInt(this.getAttribute('data-value'));
                ratingInput.value = val;

                // Update visual state of stars
                stars.forEach(s => {
                    const sVal = parseInt(s.getAttribute('data-value'));
                    if (sVal <= val) {
                        s.classList.add('star-filled', 'fill-current');
                        s.classList.remove('text-gray-600');
                    } else {
                        s.classList.remove('star-filled', 'fill-current');
                        s.classList.add('text-gray-600');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const val = parseInt(this.getAttribute('data-value'));
                stars.forEach(s => {
                    const sVal = parseInt(s.getAttribute('data-value'));
                    if (sVal <= val) {
                        s.classList.add('opacity-70');
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                stars.forEach(s => s.classList.remove('opacity-70'));
            });
        });

        // Initialize Map
        const hotel = @json($hotelData);
        if (hotel && typeof hotel.latitude !== 'undefined' && typeof hotel.longitude !== 'undefined') {
            const mapContainer = document.getElementById('hotel-map');
            if (mapContainer) {
                const map = L.map('hotel-map', {
                    zoomControl: false,
                    scrollWheelZoom: false // Better UX for scrolling pages
                }).setView([hotel.latitude, hotel.longitude], 15);

                // Use a more premium "Voyager" tile set
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);

                L.control.zoom({
                    position: 'bottomright'
                }).addTo(map);

                // Main Hotel Marker
                const hotelIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="background-color: #3490fc; width: 12px; height: 12px; border: 2px solid white; border-radius: 50%; box-shadow: 0 0 10px rgba(52, 144, 252, 0.8);"></div>`,
                    iconSize: [12, 12],
                    iconAnchor: [6, 6]
                });

                L.marker([hotel.latitude, hotel.longitude], {
                        icon: hotelIcon
                    }).addTo(map)
                    .bindPopup(`<div class="p-1 font-bold text-dark-950">${hotel.name}</div>`);

                // Add markers for nearby locations (visual fidelity)
                if (hotel.nearby && hotel.nearby.length > 0) {
                    hotel.nearby.slice(0, 3).forEach((place, index) => {
                        // Create a small deterministic offset for nearby locations
                        const offsetLat = (Math.sin(index + 1) * 0.005);
                        const offsetLng = (Math.cos(index + 1) * 0.005);

                        L.marker([hotel.latitude + offsetLat, hotel.longitude + offsetLng], {
                                icon: L.divIcon({
                                    className: 'nearby-icon',
                                    html: `<div style="background-color: #6366f1; width: 8px; height: 8px; border: 1px solid white; border-radius: 50%;"></div>`,
                                    iconSize: [8, 8],
                                    iconAnchor: [4, 4]
                                })
                            }).addTo(map)
                            .bindPopup(`<div class="p-1 text-xs text-dark-800">${place}</div>`);
                    });
                }

                // Force a resize check after a tiny delay and on window resize
                setTimeout(() => {
                    map.invalidateSize();
                }, 300);
                window.addEventListener('resize', () => {
                    map.invalidateSize();
                });
            }
        }
    });
</script>

<style>
    /* Leaflet Dark Mode Customizations */
    .leaflet-container {
        background: #0a0816;
    }

    .leaflet-bar {
        border: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
    }

    .leaflet-bar a {
        background-color: #1e1b2e !important;
        color: #ffffff !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    .leaflet-bar a:hover {
        background-color: #2d2a3e !important;
    }
</style>
@endsection