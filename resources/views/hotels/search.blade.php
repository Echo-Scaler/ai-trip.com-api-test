@extends('layouts.app')

@section('title', 'Hotel Search Results — TripExplorer')
@section('meta_description', 'Find the best hotel deals. Search results powered by Trip.com API.')

@section('content')
@php $hotelItems = $hotels->items(); @endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Search Header -->
    <div class="glass rounded-2xl p-6 mb-8">
        <form action="{{ route('hotels.search') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div class="relative location-search-container">
                <label class="block text-xs font-medium text-gray-400 mb-1.5 ml-1">{{ __('messages.destination') }}</label>
                <div class="relative">
                    <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500"></i>
                    <input type="text" name="city" id="location-input" value="{{ $params['city'] ?? '' }}" placeholder="{{ __('messages.city_name_placeholder') }}" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none input-glow focus:border-primary-500/50 transition-all" autocomplete="off">
                </div>
                <!-- Autocomplete Dropdown -->
                <div id="autocomplete-results" class="absolute z-[100] left-0 right-0 mt-2 glass rounded-xl overflow-hidden hidden shadow-2xl border border-white/10 max-h-60 overflow-y-auto"></div>
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
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ ($params['guests'] ?? 1) == $i ? 'selected' : '' }} class="bg-dark-900">{{ $i }} {{ __('messages.guest') }}{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                </select>
            </div>
            <button type="submit" class="py-3 px-6 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 flex items-center justify-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i> {{ __('messages.search') }}
            </button>
        </form>
    </div>

    <!-- Results Count & Toggle -->
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">
                @if(!empty($params['city']))
                {{ __('messages.hotels_in', ['city' => $params['city']]) }}
                @else
                {{ __('messages.all_hotels') }}
                @endif
            </h1>
            <p class="text-sm text-gray-400 mt-1">{{ $hotels->total() }} {{ __('messages.results_found') }}</p>
        </div>

        <div class="flex items-center gap-1 bg-white/5 border border-white/10 p-1 rounded-xl">
            <button onclick="toggleView('grid')" id="grid-view-btn" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all bg-primary-500 text-white shadow-lg shadow-primary-500/20">
                <i data-lucide="grid" class="w-4 h-4"></i> {{ __('messages.grid_view') }}
            </button>
            <button onclick="toggleView('map')" id="map-view-btn" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-400 hover:text-white transition-all">
                <i data-lucide="map" class="w-4 h-4"></i> {{ __('messages.map_view') }}
            </button>
        </div>
    </div>

    @if($hotels->isEmpty())
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

    <div id="results-grid" class="block">
        <!-- Hotel Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($hotels as $hotel)
            <a href="{{ route('hotels.show', $hotel['id']) }}" class="glass rounded-2xl overflow-hidden card-hover shine-effect group flex flex-col">
                <div class="relative h-48 overflow-hidden flex-shrink-0">
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
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-center gap-1 mb-2">
                        @for($i = 0; $i < $hotel['stars']; $i++)
                            <i data-lucide="star" class="w-3 h-3 star-filled fill-current"></i>
                            @endfor
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1 group-hover:text-primary-400 transition-colors line-clamp-1 truncate">{{ $hotel['name'] }}</h3>
                    <p class="text-sm text-gray-400 flex items-center gap-1 mb-3 truncate">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 flex-shrink-0"></i>
                        <span class="truncate">{{ $hotel['address'] }}, {{ $hotel['city'] }}, {{ $hotel['country'] }}</span>
                    </p>
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach(array_slice($hotel['amenities'], 0, 4) as $amenity)
                        <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-primary-500/10 text-primary-400 border border-primary-500/20 whitespace-nowrap">{{ $amenity }}</span>
                        @endforeach
                        @if(count($hotel['amenities']) > 4)
                        <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-white/5 text-gray-400 whitespace-nowrap">+{{ count($hotel['amenities']) - 4 }} {{ __('messages.more') }}</span>
                        @endif
                    </div>
                    <div class="flex items-end justify-between pt-3 border-t border-white/5 mt-auto">
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

        <!-- Pagination Links -->
        <div class="mt-8 flex justify-between items-center bg-white/5 border border-white/10 rounded-2xl p-4">
            {{ $hotels->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Map View -->
    <div id="results-map" class="hidden h-[600px] w-full glass rounded-2xl overflow-hidden relative border border-white/10">
        <div id="map" class="w-full h-full z-0"></div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    let currentView = 'grid';
    let map = null;
    let markers = [];

    const hotels = @json($hotelItems);

    function toggleView(view) {
        if (view === currentView) return;
        currentView = view;

        const grid = document.getElementById('results-grid');
        const mapContainer = document.getElementById('results-map');
        const gridBtn = document.getElementById('grid-view-btn');
        const mapBtn = document.getElementById('map-view-btn');

        if (view === 'grid') {
            grid.classList.remove('hidden');
            mapContainer.classList.add('hidden');
            gridBtn.classList.add('bg-primary-500', 'text-white', 'shadow-lg', 'shadow-primary-500/20');
            gridBtn.classList.remove('text-gray-400');
            mapBtn.classList.remove('bg-primary-500', 'text-white', 'shadow-lg', 'shadow-primary-500/20');
            mapBtn.classList.add('text-gray-400');
        } else {
            grid.classList.add('hidden');
            mapContainer.classList.remove('hidden');
            mapBtn.classList.add('bg-primary-500', 'text-white', 'shadow-lg', 'shadow-primary-500/20');
            mapBtn.classList.remove('text-gray-400');
            gridBtn.classList.remove('bg-primary-500', 'text-white', 'shadow-lg', 'shadow-primary-500/20');
            gridBtn.classList.add('text-gray-400');

            initMap();
        }
        lucide.createIcons();
    }

    function initMap() {
        if (map) {
            setTimeout(() => map.invalidateSize(), 100);
            return;
        }

        // Initialize map centered at first hotel or a default position
        const centerCoords = hotels.length > 0 ? [hotels[0].latitude, hotels[0].longitude] : [0, 0];

        map = L.map('map', {
            zoomControl: false
        }).setView(centerCoords, 10);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Add markers
        hotels.forEach(hotel => {
            if (hotel.latitude === 0 && hotel.longitude === 0) return; // Skip dynamic results without coords

            const marker = L.marker([hotel.latitude, hotel.longitude]).addTo(map);

            const hotelUrl = "{{ route('hotels.show', ':id') }}".replace(':id', hotel.id);
            const formattedPrice = new Intl.NumberFormat().format(hotel.price_per_night);

            const popupContent = `
                <div class="p-2 w-48 text-dark-950 font-sans">
                    <img src="${hotel.image_url}" class="w-full h-24 object-cover rounded-lg mb-2">
                    <h4 class="font-bold text-sm mb-1">${hotel.name}</h4>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-primary-600">${formattedPrice} USD</span>
                        <span class="text-[10px] bg-yellow-400/20 text-yellow-700 px-1.5 py-0.5 rounded flex items-center gap-1">
                            <i data-lucide="star" class="w-3 h-3 fill-current"></i> ${hotel.rating}
                        </span>
                    </div>
                    <a href="${hotelUrl}" class="block w-full text-center py-1.5 bg-primary-600 text-white rounded-lg text-xs font-bold hover:bg-primary-500 transition-all">
                        {{ __('messages.view_details') }}
                    </a>
                </div>
            `;

            marker.bindPopup(popupContent, {
                className: 'custom-popup'
            });
            markers.push(marker);
        });

        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        map.on('popupopen', function() {
            lucide.createIcons();
        });
    }

    // Autocomplete Logic
    const locationInput = document.getElementById('location-input');
    const resultsContainer = document.getElementById('autocomplete-results');
    let debounceTimer;

    locationInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            resultsContainer.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(async () => {
            try {
                const response = await fetch(`{{ route('api.locations.suggest') }}?q=${encodeURIComponent(query)}`);
                const data = await response.json();

                if (data.length > 0) {
                    resultsContainer.innerHTML = '';
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-3 hover:bg-white/10 cursor-pointer transition-colors flex items-center gap-3 border-b border-white/5 last:border-0';
                        div.innerHTML = `
                            <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="${item.type === 'city' ? 'map-pin' : 'plane'}" class="w-4 h-4 text-primary-400"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-white">${item.name}</div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-wider">${item.code} • ${item.type}</div>
                            </div>
                        `;
                        div.onclick = () => {
                            locationInput.value = item.name;
                            resultsContainer.classList.add('hidden');
                        };
                        resultsContainer.appendChild(div);
                    });
                    resultsContainer.classList.remove('hidden');
                    lucide.createIcons();
                } else {
                    resultsContainer.classList.add('hidden');
                }
            } catch (error) {
                console.error('Autocomplete error:', error);
            }
        }, 300);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.location-search-container')) {
            resultsContainer.classList.add('hidden');
        }
    });
</script>

<style>
    /* Leaflet Dark Mode Customizations */
    .leaflet-container {
        background: #0a0816;
    }

    .custom-popup .leaflet-popup-content-wrapper {
        background: #ffffff;
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    }

    .custom-popup .leaflet-popup-content {
        margin: 0;
    }

    .custom-popup .leaflet-popup-tip {
        background: #ffffff;
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