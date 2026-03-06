@extends('layouts.app')

@section('title', $hotel['name'] . ' — TripExplorer')
@section('meta_description', $hotel['description'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <nav class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="{{ route('hotels.search') }}" class="hover:text-primary-400 transition-colors">Hotels</a>
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
                    Save {{ round((1 - $hotel['price_per_night'] / $hotel['original_price']) * 100) }}%
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
                    <i data-lucide="info" class="w-5 h-5 text-primary-400"></i> About this hotel
                </h2>
                <p class="text-gray-300 leading-relaxed">{{ $hotel['description'] }}</p>
            </div>

            <!-- Amenities -->
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-primary-400"></i> Amenities
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

            <!-- Room Options -->
            @if(isset($hotel['rooms']))
            <div class="glass rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="bed-double" class="w-5 h-5 text-primary-400"></i> Available Rooms
                </h2>
                <div class="space-y-4">
                    @foreach($hotel['rooms'] as $room)
                    <div class="glass-light rounded-xl p-5 hover:bg-white/10 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
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
                                <div class="text-2xl font-bold text-white">${{ number_format($room['price']) }}</div>
                                <div class="text-xs text-gray-400 mb-3">per night</div>
                                <a href="{{ route('booking.create', ['type' => 'hotel', 'item_id' => $hotel['id'], 'item_name' => $hotel['name'] . ' — ' . $room['name'], 'price' => $room['price'], 'currency' => $hotel['currency']]) }}"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25">
                                    Book Now
                                </a>
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
                    <i data-lucide="file-text" class="w-5 h-5 text-primary-400"></i> Hotel Policies
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="log-in" class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="text-sm font-medium text-white">Check-in</div>
                            <div class="text-sm text-gray-400">{{ $hotel['policies']['check_in'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i data-lucide="log-out" class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="text-sm font-medium text-white">Check-out</div>
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
                    <i data-lucide="messages-square" class="w-6 h-6 text-primary-400"></i> Guest Reviews
                </h2>

                @if(isset($reviews) && $reviews->isNotEmpty())
                <div class="space-y-6 mb-8">
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
                </div>
                @else
                <div class="text-center py-8 glass-light rounded-xl border border-dashed border-white/10 mb-8">
                    <i data-lucide="message-circle" class="w-10 h-10 text-gray-500 mx-auto mb-3"></i>
                    <h3 class="text-white font-bold mb-1">No reviews yet</h3>
                    <p class="text-sm text-gray-400">Be the first to share your experience at this hotel!</p>
                </div>
                @endif

                <!-- Write a Review Form -->
                <div class="glass-light rounded-xl p-6 border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-4">Write a Review</h3>
                    <form action="{{ route('reviews.store', $hotel['id']) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Your Name</label>
                            <input type="text" name="user_name" required class="w-full bg-dark-900 border border-white/10 rounded-xl py-2.5 px-4 text-white focus:outline-none focus:border-primary-500 transition-colors" placeholder="John Doe">
                            @error('user_name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                            <input type="hidden" name="rating" id="rating-input" value="5">
                            <div class="flex items-center gap-1 cursor-pointer" id="star-selector">
                                @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" data-value="{{ $i }}" class="w-6 h-6 star-select star-filled fill-current transition-colors"></i>
                                    @endfor
                            </div>
                            @error('rating') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Your Review</label>
                            <textarea name="comment" required rows="3" class="w-full bg-dark-900 border border-white/10 rounded-xl py-3 px-4 text-white focus:outline-none focus:border-primary-500 transition-colors" placeholder="Tell us about your stay..."></textarea>
                            @error('comment') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25">
                            Post Review
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
                    <div class="text-sm text-gray-400 mb-1">Starting from</div>
                    @if(isset($hotel['original_price']))
                    <div class="text-sm text-gray-500 line-through">${{ number_format($hotel['original_price']) }}</div>
                    @endif
                    <div class="text-3xl font-black text-white">${{ number_format($hotel['price_per_night']) }}<span class="text-base font-normal text-gray-400">/night</span></div>
                </div>
                <a href="{{ route('booking.create', ['type' => 'hotel', 'item_id' => $hotel['id'], 'item_name' => $hotel['name'], 'price' => $hotel['price_per_night'], 'currency' => $hotel['currency']]) }}"
                    class="block w-full py-3.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white text-center font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25 hover:shadow-primary-500/40">
                    Book Now
                </a>
                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i>
                    Free cancellation available
                </div>
            </div>

            <!-- Nearby -->
            @if(isset($hotel['nearby']))
            <div class="glass rounded-2xl p-6">
                <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="compass" class="w-4 h-4 text-primary-400"></i> Nearby
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
                    <i data-lucide="message-square" class="w-4 h-4 text-primary-400"></i> Guest Reviews
                </h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="text-3xl font-black text-white">{{ $hotel['rating'] }}</div>
                    <div>
                        <div class="flex items-center gap-0.5">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="w-4 h-4 {{ $i < round($hotel['rating']) ? 'star-filled fill-current' : 'text-gray-600' }}"></i>
                                @endfor
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ number_format($hotel['review_count'] ?? 0) }} reviews</div>
                    </div>
                </div>
                <div class="text-sm text-gray-400">
                    @if($hotel['rating'] >= 4.5) Exceptional
                    @elseif($hotel['rating'] >= 4.0) Excellent
                    @elseif($hotel['rating'] >= 3.5) Very Good
                    @else Good
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
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

            // Optional: Hover effects
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
    });
</script>
@endsection