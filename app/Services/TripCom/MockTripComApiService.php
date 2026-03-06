<?php

namespace App\Services\TripCom;

use App\Contracts\TripComApiContract;

class MockTripComApiService implements TripComApiContract
{
    /**
     * Curated premium hotel images from Unsplash based on categories.
     */
    protected array $hotelImagePool = [
        'Luxury' => [
            'https://images.unsplash.com/photo-1542314831-c6a4d14b434b?w=800&q=80',
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80',
            'https://images.unsplash.com/photo-1549294413-26f195af0cb6?w=800&q=80',
        ],
        'Beach' => [
            'https://images.unsplash.com/photo-1584132967334-10e028ae8757?w=800&q=80',
            'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80',
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
            'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800&q=80',
        ],
        'Modern' => [
            'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80',
            'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80',
            'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=800&q=80',
        ],
        'City' => [
            'https://images.unsplash.com/photo-1496417263034-38ec4f0b665a?w=800&q=80',
            'https://images.unsplash.com/photo-1502602898657-3e917240a182?w=800&q=80',
            'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800&q=80',
            'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=800&q=80',
        ],
        'Heritage' => [
            'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800&q=80',
            'https://images.unsplash.com/photo-1560624052-449f5ddf0c31?w=800&q=80',
            'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800&q=80',
            'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?w=800&q=80',
        ],
        'Vietnam' => [
            'https://images.unsplash.com/photo-1583417319070-4a69db38a482?w=800&q=80', // Hoi An Style
            'https://images.unsplash.com/photo-1596436889106-be35e843f974?w=800&q=80', // Hill Resort
            'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80', // Tropical Resort
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', // High-end Da Nang
        ],
    ];

    /**
     * Curated premium airline logos from Wikimedia/stable sources.
     */
    protected array $airlineLogoPool = [
        'Singapore Airlines' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/6b/Singapore_Airlines_Logo_2.svg/300px-Singapore_Airlines_Logo_2.svg.png',
        'ANA' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/All_Nippon_Airways_Logo.svg/300px-All_Nippon_Airways_Logo.svg.png',
        'Emirates' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Emirates_logo.svg/300px-Emirates_logo.svg.png',
        'Qatar Airways' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/14/Qatar_Airways_Logo.svg/300px-Qatar_Airways_Logo.svg.png',
        'Cathay Pacific' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/17/Cathay_Pacific_logo.svg/300px-Cathay_Pacific_logo.svg.png',
        'Japan Airlines' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/16/Japan_Airlines_logo_%282011%29.svg/300px-Japan_Airlines_logo_%282011%29.svg.png',
        'Lufthansa' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Lufthansa_Logo_2018.svg/300px-Lufthansa_Logo_2018.svg.png',
        'Etihad Airways' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Etihad_airways_logo.svg/300px-Etihad_airways_logo.svg.png',
        'British Airways' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e4/British_Airways_Logo.svg/300px-British_Airways_Logo.svg.png',
        'Air France' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Air_France_Logo.svg/300px-Air_France_Logo.svg.png',
    ];

    /**
     * Pre-populated realistic city coordinates.
     */
    protected array $cityCoords = [
        'Tokyo' => ['lat' => 35.6762, 'lng' => 139.6503],
        'Singapore' => ['lat' => 1.3521, 'lng' => 103.8198],
        'Bangkok' => ['lat' => 13.7563, 'lng' => 100.5018],
        'Hanoi' => ['lat' => 21.0285, 'lng' => 105.8542],
        'Seoul' => ['lat' => 37.5665, 'lng' => 126.9780],
        'Bali' => ['lat' => -8.4095, 'lng' => 115.1889],
        'Phuket' => ['lat' => 7.8804, 'lng' => 98.3923],
        'Hong Kong' => ['lat' => 22.3193, 'lng' => 114.1694],
        'Taipei' => ['lat' => 25.0330, 'lng' => 121.5654],
        'Dubai' => ['lat' => 25.2048, 'lng' => 55.2708],
        'Jakarta' => ['lat' => -6.2088, 'lng' => 106.8456],
        'Kuala Lumpur' => ['lat' => 3.1390, 'lng' => 101.6869],
        'Manila' => ['lat' => 14.5995, 'lng' => 120.9842],
        'London' => ['lat' => 51.5074, 'lng' => -0.1278],
        'New York' => ['lat' => 40.7128, 'lng' => -74.0060],
        'Paris' => ['lat' => 48.8566, 'lng' => 2.3522],
        'Sydney' => ['lat' => -33.8688, 'lng' => 151.2093],
        'Berlin' => ['lat' => 52.5200, 'lng' => 13.4050],
        'Rome' => ['lat' => 41.9028, 'lng' => 12.4964],
        'Zurich' => ['lat' => 47.3769, 'lng' => 8.5417],
        'Toronto' => ['lat' => 43.6532, 'lng' => -79.3832],
        'Madrid' => ['lat' => 40.4168, 'lng' => -3.7038],
        'Barcelona' => ['lat' => 41.3851, 'lng' => 2.1734],
        'Amsterdam' => ['lat' => 52.3676, 'lng' => 4.9041],
        'Prague' => ['lat' => 50.0755, 'lng' => 14.4378],
        'Vienna' => ['lat' => 48.2082, 'lng' => 16.3738],
        'Athens' => ['lat' => 37.9838, 'lng' => 23.7275],
        'Lisbon' => ['lat' => 38.7223, 'lng' => -9.1393],
        'Istanbul' => ['lat' => 41.0082, 'lng' => 28.9784],
        'San Francisco' => ['lat' => 37.7749, 'lng' => -122.4194],
        'Los Angeles' => ['lat' => 34.0522, 'lng' => -118.2437],
        'Miami' => ['lat' => 25.7617, 'lng' => -80.1918],
        'Mexico City' => ['lat' => 19.4326, 'lng' => -99.1332],
        'Rio de Janeiro' => ['lat' => -22.9068, 'lng' => -43.1729],
        'Buenos Aires' => ['lat' => -34.6037, 'lng' => -58.3816],
        'Cape Town' => ['lat' => -33.9249, 'lng' => 18.4241],
        'Cairo' => ['lat' => 30.0444, 'lng' => 31.2357],
        'Marrakech' => ['lat' => 31.6295, 'lng' => -7.9811],
        'Melbourne' => ['lat' => -37.8136, 'lng' => 144.9631],
        'Auckland' => ['lat' => -36.8485, 'lng' => 174.7633],
        'Tehran' => ['lat' => 35.6892, 'lng' => 51.3890],
    ];

    /**
     * Pool of realistic reviews.
     */
    protected array $reviewPool = [
        ['user' => 'Sarah J.', 'rating' => 5, 'comment' => 'Absolutely stunning view! The service was impeccable and the room was spotlessly clean.'],
        ['user' => 'Michael R.', 'rating' => 4, 'comment' => 'Great location, very central. The breakfast selection was amazing, though the gym was a bit small.'],
        ['user' => 'Elena G.', 'rating' => 5, 'comment' => 'Best stay ever! Staff went above and beyond to make our anniversary special.'],
        ['user' => 'David K.', 'rating' => 3, 'comment' => 'Good value for money, but the WiFi was quite spotty in the evenings.'],
        ['user' => 'Aiko M.', 'rating' => 5, 'comment' => 'Incredible experience. The rooftop bar is a must-visit!'],
        ['user' => 'Robert P.', 'rating' => '4', 'comment' => 'Very comfortable beds. A bit noisy on the street side, but the double glazing helps.'],
    ];

    /**
     * Pool of high-quality room images.
     */
    protected array $roomImagePool = [
        'Deluxe' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80',
        'Suite' => 'https://images.unsplash.com/photo-1590490359683-658d3d23f972?w=800&q=80',
        'Family' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&q=80',
        'Standard' => 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?w=800&q=80',
    ];

    /**
     * Pool of high-quality amenity/gallery images.
     */
    protected array $amenityImagePool = [
        'https://images.unsplash.com/photo-1584132967334-10e028ae8757?w=800&q=80', // Pool
        'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80', // Gym
        'https://images.unsplash.com/photo-1544161515-4af6b1d46bdc?w=800&q=80', // Spa
        'https://images.unsplash.com/photo-1550966841-3ee7adac1623?w=800&q=80', // Restaurant
        'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=800&q=80', // Bar
        'https://images.unsplash.com/photo-1496417263034-38ec4f0b665a?w=800&q=80', // Lobby
        'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', // Bedroom view
        'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80', // Bathroom
        'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80', // Terrace
    ];

    /**
     * Mock hotel data — generate realistic sample hotels if not in cache.
     */
    protected function getMockHotels(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('mock_hotels', 3600, function () {
            $baseHotels = [
                // Hanoi, Vietnam
                ['name' => 'Capella Hanoi', 'city' => 'Hanoi', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'desc' => 'An opulent, art deco-inspired hotel paying homage to the Roaring Twenties and the opera.', 'lat' => 21.0245, 'lng' => 105.8524],
                ['name' => 'Sofitel Legend Metropole Hanoi', 'city' => 'Hanoi', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80', 'desc' => 'A historic luxury hotel combining French colonial grandeur with neoclassical elegance, dating back to 1901.', 'lat' => 21.0256, 'lng' => 105.8560],
                ['name' => 'JW Marriott Hotel Hanoi', 'city' => 'Hanoi', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'desc' => 'A contemporary luxury hotel with expressive architecture, overlooking the National Convention Center.', 'lat' => 21.0069, 'lng' => 105.7833],
                ['name' => 'Melia Hanoi', 'city' => 'Hanoi', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80', 'desc' => 'Centrally located with sophisticated rooms and spectacular views of the city.', 'lat' => 21.0243, 'lng' => 105.8486],

                // Ho Chi Minh City, Vietnam
                ['name' => 'Hôtel des Arts Saigon', 'city' => 'Ho Chi Minh', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80', 'desc' => 'A luxury boutique hotel that channels the elegance of 1930s Indochine with an art-focused design.', 'lat' => 10.7820, 'lng' => 106.6971],
                ['name' => 'Park Hyatt Saigon', 'city' => 'Ho Chi Minh', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'desc' => 'A refined retreat with French-colonial architecture and courtyard gardens in the heart of the city.', 'lat' => 10.7764, 'lng' => 106.7011],
                ['name' => 'The Reverie Saigon', 'city' => 'Ho Chi Minh', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1542314831-c6a4d14b434b?w=800&q=80', 'desc' => 'An extravagantly luxurious hotel showcasing a collaboration of Italian design and craftsmanship.', 'lat' => 10.7744, 'lng' => 106.7042],
                ['name' => 'La Siesta Premium Sai Gon', 'city' => 'Ho Chi Minh', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80', 'desc' => 'A boutique gem offering contemporary design and a blend of luxury and affordability.', 'lat' => 10.7719, 'lng' => 106.6983],

                // Tokyo, Japan
                ['name' => 'Aman Tokyo', 'city' => 'Tokyo', 'country' => 'Japan', 'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80', 'desc' => 'A sanctuary at the top of the Otemachi Tower, blending traditional Japanese style with contemporary comfort.', 'lat' => 35.6856, 'lng' => 139.7654],
                ['name' => 'Andaz Tokyo Toranomon Hills', 'city' => 'Tokyo', 'country' => 'Japan', 'image' => 'https://images.unsplash.com/photo-1549294413-26f195af0cb6?w=800&q=80', 'desc' => 'A lifestyle boutique hotel offering breathtaking views and a sophisticated, modern atmosphere.', 'lat' => 35.6669, 'lng' => 139.7507],
                ['name' => 'Park Hyatt Tokyo', 'city' => 'Tokyo', 'country' => 'Japan', 'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=800&q=80', 'desc' => 'An icon of contemporary luxury, famous for its cinematic views and impeccable service.', 'lat' => 35.6851, 'lng' => 139.6910],
                ['name' => 'The Tokyo Station Hotel', 'city' => 'Tokyo', 'country' => 'Japan', 'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800&q=80', 'desc' => 'A historic landmark located inside the iconic Tokyo Station building, offering timeless elegance.', 'lat' => 35.6752, 'lng' => 139.7668],

                // Fukuoka, Japan
                ['name' => 'The Ritz-Carlton, Fukuoka', 'city' => 'Fukuoka', 'country' => 'Japan', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'desc' => 'A vertical urban sanctuary offering breathtaking views of Hakata Bay and refined luxury.'],
                ['name' => 'Grand Hyatt Fukuoka', 'city' => 'Fukuoka', 'country' => 'Japan', 'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'desc' => 'A 5-star hotel located in the heart of Canal City Hakata, offering world-class comfort.'],

                // Tehran, Iran
                ['name' => 'Espinas Palace Hotel', 'city' => 'Tehran', 'country' => 'Iran', 'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800&q=80', 'desc' => 'A magnificent iconic hotel on the Saadat Abad hills, known for its grand architecture and luxury.', 'lat' => 35.7933, 'lng' => 51.3564],
                ['name' => 'Parsian Azadi Hotel', 'city' => 'Tehran', 'country' => 'Iran', 'image' => 'https://images.unsplash.com/photo-1560624052-449f5ddf0c31?w=800&q=80', 'desc' => 'One of Iran’s most modern and attractive hotels, overlooking the Alborz mountains.', 'lat' => 35.7877, 'lng' => 51.3855],
                ['name' => 'Parsian Esteghlal International', 'city' => 'Tehran', 'country' => 'Iran', 'image' => 'https://images.unsplash.com/photo-1496417263034-38ec4f0b665a?w=800&q=80', 'desc' => 'A classic Iranian luxury landmark located at the foot of the Alborz mountain range.', 'lat' => 35.7892, 'lng' => 51.4056],
                ['name' => 'Laleh Hotel Tehran', 'city' => 'Tehran', 'country' => 'Iran', 'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800&q=80', 'desc' => 'A stylish 5-star hotel situated by Laleh Park, offering views of Damavand Mount Peak.', 'lat' => 35.7100, 'lng' => 51.3900],

                // World Cities
                ['name' => 'The Ritz London', 'city' => 'London', 'country' => 'UK', 'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=800&q=80', 'desc' => 'A world-famous icon of luxury and elegance, delivering impeccable service since 1906.'],
                ['name' => 'Empire State Stay', 'city' => 'New York', 'country' => 'USA', 'image' => 'https://images.unsplash.com/photo-1496417263034-38ec4f0b665a?w=800&q=80', 'desc' => 'Modern luxury in the heart of Manhattan, just steps away from iconic landmarks.'],
            ];


            $allHotels = [];
            $amenitiesPool = ['Free WiFi', 'Pool', 'Spa', 'Restaurant', 'Gym', 'Bar', 'Room Service', 'Airport Shuttle', 'Yoga Studio', 'Ocean View', 'Casino', 'Free Breakfast'];

            for ($i = 1; $i <= 100; $i++) {
                $base = $baseHotels[array_rand($baseHotels)];
                $coords = $this->cityCoords[$base['city']] ?? ['lat' => 0, 'lng' => 0];

                $price = rand(80, 500);

                // Shuffle and pick 4-6 random amenities
                $shuffleAmenities = $amenitiesPool;
                shuffle($shuffleAmenities);
                $amenities = array_slice($shuffleAmenities, 0, rand(4, 6));

                // Select image based on style/region
                $style = 'Modern';
                if (str_contains($base['name'], 'Grand') || str_contains($base['name'], 'Imperial')) $style = 'Luxury';
                if (str_contains($base['name'], 'Resort') || str_contains($base['city'], 'Bali')) $style = 'Beach';
                if (str_contains($base['name'], 'Heritage') || str_contains($base['city'], 'Rome')) $style = 'Heritage';
                if (strtolower($base['country']) === 'vietnam') $style = 'Vietnam';

                $stylePool = $this->hotelImagePool[$style] ?? $this->hotelImagePool['Modern'];
                $imageUrl = $stylePool[array_rand($stylePool)];

                $suffixes = ['', 'Residences', 'Premier', 'Collection', 'Heritage', 'Suites', 'Inn', 'Plaza'];
                $suffix = ($i > count($baseHotels)) ? ' ' . $suffixes[array_rand($suffixes)] : '';

                $allHotels[] = [
                    'id' => $i,
                    'name' => $base['name'] . $suffix,
                    'address' => rand(10, 999) . ' Main Street, Central District',
                    'city' => $base['city'],
                    'country' => $base['country'],
                    'rating' => round(rand(35, 50) / 10, 1),
                    'stars' => rand(3, 5),
                    'price_per_night' => $price,
                    'original_price' => rand(0, 1) ? $price + rand(20, 100) : $price,
                    'currency' => 'USD',
                    'image_url' => $imageUrl,
                    'amenities' => $amenities,
                    'description' => $base['desc'] ?? ('A wonderful stay at ' . $base['name'] . ' located in ' . $base['city'] . '. Enjoy premium amenities and world-class service.'),
                    'latitude' => $base['lat'] ?? ($coords['lat'] + (rand(-100, 100) / 1000)), // Use specific lat if available, else random city offset
                    'longitude' => $base['lng'] ?? ($coords['lng'] + (rand(-100, 100) / 1000)),
                    'review_count' => rand(50, 5000),
                ];
            }

            return $allHotels;
        });
    }

    /**
     * Mock flight data — generate realistic sample flights.
     */
    protected function getMockFlights(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('mock_flights', 3600, function () {
            $airlines = [
                ['name' => 'Singapore Airlines', 'logo' => $this->airlineLogoPool['Singapore Airlines']],
                ['name' => 'ANA', 'logo' => $this->airlineLogoPool['ANA']],
                ['name' => 'Emirates', 'logo' => $this->airlineLogoPool['Emirates']],
                ['name' => 'Qatar Airways', 'logo' => $this->airlineLogoPool['Qatar Airways']],
                ['name' => 'Cathay Pacific', 'logo' => $this->airlineLogoPool['Cathay Pacific']],
                ['name' => 'Japan Airlines', 'logo' => $this->airlineLogoPool['Japan Airlines']],
                ['name' => 'Lufthansa', 'logo' => $this->airlineLogoPool['Lufthansa']],
                ['name' => 'British Airways', 'logo' => $this->airlineLogoPool['British Airways']],
            ];

            $airports = [
                ['code' => 'NRT', 'city' => 'Tokyo', 'country' => 'Japan'],
                ['code' => 'SIN', 'city' => 'Singapore', 'country' => 'Singapore'],
                ['code' => 'BKK', 'city' => 'Bangkok', 'country' => 'Thailand'],
                ['code' => 'ICN', 'city' => 'Seoul', 'country' => 'South Korea'],
                ['code' => 'HKG', 'city' => 'Hong Kong', 'country' => 'Hong Kong'],
                ['code' => 'DPS', 'city' => 'Bali', 'country' => 'Indonesia'],
                ['code' => 'DXB', 'city' => 'Dubai', 'country' => 'United Arab Emirates'],
                ['code' => 'SGN', 'city' => 'Ho Chi Minh', 'country' => 'Vietnam'],
                ['code' => 'LHR', 'city' => 'London', 'country' => 'United Kingdom'],
                ['code' => 'JFK', 'city' => 'New York', 'country' => 'USA'],
                ['code' => 'CDG', 'city' => 'Paris', 'country' => 'France'],
                ['code' => 'SYD', 'city' => 'Sydney', 'country' => 'Australia'],
                ['code' => 'FCO', 'city' => 'Rome', 'country' => 'Italy'],
                ['code' => 'YYZ', 'city' => 'Toronto', 'country' => 'Canada'],
                ['code' => 'FRA', 'city' => 'Frankfurt', 'country' => 'Germany'],
                ['code' => 'MAD', 'city' => 'Madrid', 'country' => 'Spain'],
                ['code' => 'AMS', 'city' => 'Amsterdam', 'country' => 'Netherlands'],
                ['code' => 'BCN', 'city' => 'Barcelona', 'country' => 'Spain'],
                ['code' => 'PRG', 'city' => 'Prague', 'country' => 'Czech Republic'],
                ['code' => 'VIE', 'city' => 'Vienna', 'country' => 'Austria'],
                ['code' => 'ATH', 'city' => 'Athens', 'country' => 'Greece'],
                ['code' => 'LIS', 'city' => 'Lisbon', 'country' => 'Portugal'],
                ['code' => 'IST', 'city' => 'Istanbul', 'country' => 'Turkey'],
                ['code' => 'SFO', 'city' => 'San Francisco', 'country' => 'USA'],
                ['code' => 'LAX', 'city' => 'Los Angeles', 'country' => 'USA'],
                ['code' => 'MIA', 'city' => 'Miami', 'country' => 'USA'],
                ['code' => 'MEX', 'city' => 'Mexico City', 'country' => 'Mexico'],
                ['code' => 'GIG', 'city' => 'Rio de Janeiro', 'country' => 'Brazil'],
                ['code' => 'EZE', 'city' => 'Buenos Aires', 'country' => 'Argentina'],
                ['code' => 'CPT', 'city' => 'Cape Town', 'country' => 'South Africa'],
                ['code' => 'CAI', 'city' => 'Cairo', 'country' => 'Egypt'],
                ['code' => 'RAK', 'city' => 'Marrakech', 'country' => 'Morocco'],
                ['code' => 'MEL', 'city' => 'Melbourne', 'country' => 'Australia'],
                ['code' => 'AKL', 'city' => 'Auckland', 'country' => 'New Zealand'],
            ];

            $allFlights = [];

            for ($i = 1; $i <= 40; $i++) {
                $airline = $airlines[array_rand($airlines)];
                $origin = $airports[array_rand($airports)];

                // Ensure origin != destination
                do {
                    $destination = $airports[array_rand($airports)];
                } while ($destination['code'] === $origin['code']);

                $price = rand(150, 1200);
                $departHour = rand(0, 23);
                $departMin = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                $durationHours = rand(2, 14);
                $durationMins = rand(0, 59);

                $arrivalHour = ($departHour + $durationHours) % 24;
                $arrivalDay = ($departHour + $durationHours) >= 24 ? '+1' : '';

                $allFlights[] = [
                    'id' => $i,
                    'airline' => $airline['name'],
                    'airline_logo' => $airline['logo'],
                    'flight_number' => substr($airline['name'], 0, 2) . ' ' . rand(100, 999),
                    'origin' => $origin['code'],
                    'origin_city' => $origin['city'],
                    'origin_country' => $origin['country'],
                    'destination' => $destination['code'],
                    'destination_city' => $destination['city'],
                    'destination_country' => $destination['country'],
                    'departure_time' => str_pad($departHour, 2, '0', STR_PAD_LEFT) . ':' . $departMin,
                    'arrival_time' => str_pad($arrivalHour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($durationMins, 2, '0', STR_PAD_LEFT) . $arrivalDay,
                    'duration' => $durationHours . 'h ' . $durationMins . 'm',
                    'price' => $price,
                    'original_price' => rand(0, 1) ? $price + rand(50, 200) : $price,
                    'currency' => 'USD',
                    'cabin_class' => rand(0, 1) ? 'Economy' : 'Business',
                    'stops' => rand(0, 2),
                    'aircraft' => rand(0, 1) ? 'Boeing 787-' . rand(8, 9) : 'Airbus A' . rand(330, 380),
                    'baggage' => rand(20, 30) . 'kg checked + 7kg cabin',
                ];
            }

            return $allFlights;
        });
    }

    /**
     * Search for hotels based on criteria.
     */
    public function searchHotels(array $params)
    {
        $hotels = collect($this->getMockHotels());
        $queryStr = trim($params['city'] ?? '');

        // Filter by query (searches name, city, country)
        if (!empty($queryStr)) {
            $input = strtolower($queryStr);
            $queries = explode(',', $input);
            $queries = array_map('trim', $queries);
            $queries = array_filter($queries);

            $hotels = $hotels->filter(function ($hotel) use ($queries) {
                // All parts of the comma-separated query must match some part of the hotel metadata
                foreach ($queries as $query) {
                    $match = str_contains(strtolower($hotel['city']), $query)
                        || str_contains(strtolower($hotel['name']), $query)
                        || str_contains(strtolower($hotel['country']), $query);
                    if (!$match) return false;
                }
                return true;
            });

            // If no results found, generate dynamic mock results for this specific query
            if ($hotels->isEmpty()) {
                $hotels = $this->generateDynamicHotels($queryStr);
            }
        }

        // Return a paginator instance instead of an array
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 9; // Display 3x3 grid

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $hotels->forPage($currentPage, $perPage)->values(), // Items for current page
            $hotels->count(), // Total items
            $perPage, // Items per page
            $currentPage, // Current page
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()] // Options for URL generation
        );
    }

    /**
     * Generate dynamic hotel results when no matches are found.
     */
    protected function generateDynamicHotels(string $query): \Illuminate\Support\Collection
    {
        $dynamicHotels = [];
        $queryParts = array_map('trim', explode(',', $query));
        $mainLocation = ucwords($queryParts[0]);
        $secondaryLocation = isset($queryParts[1]) ? ucwords($queryParts[1]) : '';

        $names = ['Grand', 'Regency', 'Palace', 'Royal', 'Resort', 'Suites', 'Inn', 'Boutique', 'Views', 'Central'];
        $styles = ['Modern', 'Luxury', 'Heritage', 'Beach', 'Skyline', 'Elite', 'Boutique', 'Classic'];

        // Deterministic random seed based on query to keep results consistent per search
        srand(crc32(strtolower($query)));

        for ($i = 1; $i <= 12; $i++) {
            $style = $styles[array_rand($styles)];
            $name = $names[array_rand($names)];
            $hotelName = "{$style} {$mainLocation} {$name}";

            $stylePool = $this->hotelImagePool[$style] ?? $this->hotelImagePool['Modern'];

            // Special handling for Vietnam/Asia style images if query suggests it
            if (str_contains(strtolower($query), 'vietnam') || str_contains(strtolower($query), 'hanoi') || str_contains(strtolower($query), 'ho chi minh')) {
                $stylePool = $this->hotelImagePool['Vietnam'];
            }

            $imageUrl = $stylePool[array_rand($stylePool)];

            // Smarter pricing based on city importance (Tier-1 cities more expensive)
            $tier1Cities = ['Tokyo', 'New York', 'London', 'Paris', 'Dubai', 'Singapore', 'Hong Kong'];
            $basePrice = in_array($mainLocation, $tier1Cities) ? rand(250, 600) : rand(120, 350);
            $price = $basePrice + rand(-20, 50);

            $rating = 4.0 + (rand(0, 10) / 10);

            // Get coordinates for city or generate nearby placeholder
            $baseCoords = $this->cityCoords[$mainLocation] ?? [
                'lat' => rand(-60, 60) + (rand(0, 1000) / 1000),
                'lng' => rand(-180, 180) + (rand(0, 1000) / 1000)
            ];

            $dynamicHotels[] = [
                'id' => 'dh_' . $i . '_' . base64_encode($query),
                'name' => $hotelName,
                'address' => rand(1, 999) . " Avenue St, {$mainLocation}",
                'city' => $mainLocation,
                'country' => $secondaryLocation ?: 'International',
                'rating' => $rating,
                'stars' => rand(4, 5),
                'price_per_night' => $price,
                'original_price' => rand(0, 1) ? $price + rand(30, 80) : $price,
                'currency' => 'USD',
                'image_url' => $imageUrl,
                'amenities' => ['Free WiFi', 'Pool', 'Restaurant', 'Gym', 'Spa'],
                'description' => "Welcome to {$hotelName}, the premier destination in {$mainLocation}. Experience luxury and comfort at its finest.",
                'latitude' => $baseCoords['lat'] + (rand(-50, 50) / 1000),
                'longitude' => $baseCoords['lng'] + (rand(-50, 50) / 1000),
                'review_count' => rand(100, 2000),
            ];
        }

        // Reset seed
        srand();

        return collect($dynamicHotels);
    }

    /**
     * Get detailed information about a specific hotel.
     */
    public function getHotelDetail(string|int $hotelId): ?array
    {
        $hotel = null;

        // Check if it's a dynamic ID
        if (is_string($hotelId) && str_starts_with($hotelId, 'dh_')) {
            try {
                // ID format: dh_[index]_[base64_query]
                $parts = explode('_', $hotelId);
                if (count($parts) >= 3) {
                    $index = (int)$parts[1];
                    $query = base64_decode($parts[2]);
                    if ($query) {
                        $dynamicHotels = $this->generateDynamicHotels($query);
                        $hotel = $dynamicHotels->first(fn($h) => $h['id'] == $hotelId);
                    }
                }
            } catch (\Exception $e) {
                // Fallback to null
            }
        } else {
            $hotels = $this->getMockHotels();
            foreach ($hotels as $h) {
                if ($h['id'] == $hotelId) {
                    $hotel = $h;
                    break;
                }
            }
        }

        if ($hotel) {
            // Add a gallery of images
            $hotel['gallery'] = $this->amenityImagePool;
            shuffle($hotel['gallery']);
            $hotel['gallery'] = array_slice($hotel['gallery'], 0, 5);

            // Add extra detail fields for the detail view
            $hotel['rooms'] = [
                [
                    'name' => 'Deluxe Double Room',
                    'price' => $hotel['price_per_night'],
                    'max_guests' => 2,
                    'bed_type' => 'King Bed',
                    'size' => '35 m²',
                    'includes' => ['Breakfast', 'Free Cancellation'],
                    'image_url' => $this->roomImagePool['Deluxe'],
                ],
                [
                    'name' => 'Premium Suite',
                    'price' => $hotel['price_per_night'] * 1.6,
                    'max_guests' => 3,
                    'bed_type' => 'King Bed + Sofa Bed',
                    'size' => '55 m²',
                    'includes' => ['Breakfast', 'Lounge Access', 'Free Cancellation', 'Late Checkout'],
                    'image_url' => $this->roomImagePool['Suite'],
                ],
                [
                    'name' => 'Executive Family Room',
                    'price' => $hotel['price_per_night'] * 1.3,
                    'max_guests' => 4,
                    'bed_type' => '2 Queen Beds',
                    'size' => '45 m²',
                    'includes' => ['Breakfast', 'Free Cancellation'],
                    'image_url' => $this->roomImagePool['Family'],
                ],
            ];
            $hotel['policies'] = [
                'check_in' => '15:00',
                'check_out' => '11:00',
                'cancellation' => 'Free cancellation up to 24 hours before check-in',
                'children' => 'Children of all ages are welcome',
                'pets' => 'Pets are not allowed',
            ];
            $hotel['nearby'] = [
                'Airport — 45 min drive',
                'City Center — 10 min walk',
                'Train Station — 5 min walk',
                'Shopping Mall — 15 min walk',
            ];

            // Add realistic mock reviews
            $shuffledReviews = $this->reviewPool;
            shuffle($shuffledReviews);
            $hotel['reviews'] = array_slice($shuffledReviews, 0, rand(3, 5));
            foreach ($hotel['reviews'] as &$review) {
                $review['date'] = date('Y-m-d', strtotime('-' . rand(1, 180) . ' days'));
            }

            return $hotel;
        }

        return null;
    }

    /**
     * Search for flights based on criteria.
     */
    public function searchFlights(array $params)
    {
        $flights = collect($this->getMockFlights());
        $originVal = trim($params['origin'] ?? '');
        $destVal = trim($params['destination'] ?? '');

        // Filter by origin
        if (!empty($originVal)) {
            $input = strtolower($originVal);
            $queries = explode(',', $input);
            $queries = array_map('trim', $queries);
            $queries = array_filter($queries);

            $flights = $flights->filter(function ($flight) use ($queries) {
                foreach ($queries as $query) {
                    $match = str_contains(strtolower($flight['origin']), $query)
                        || str_contains(strtolower($flight['origin_city']), $query)
                        || str_contains(strtolower($flight['origin_country']), $query);
                    if (!$match) return false;
                }
                return true;
            });
        }

        // Filter by destination
        if (!empty($destVal)) {
            $input = strtolower($destVal);
            $queries = explode(',', $input);
            $queries = array_map('trim', $queries);
            $queries = array_filter($queries);

            $flights = $flights->filter(function ($flight) use ($queries) {
                foreach ($queries as $query) {
                    $match = str_contains(strtolower($flight['destination']), $query)
                        || str_contains(strtolower($flight['destination_city']), $query)
                        || str_contains(strtolower($flight['destination_country']), $query);
                    if (!$match) return false;
                }
                return true;
            });
        }

        // If no results found, generate dynamic flight results
        if ($flights->isEmpty() && (!empty($originVal) || !empty($destVal))) {
            $flights = $this->generateDynamicFlights($originVal, $destVal);
        }

        // Return a paginator instance instead of an array
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10; // Display 10 flights per page

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $flights->forPage($currentPage, $perPage)->values(), // Items for current page
            $flights->count(), // Total items
            $perPage, // Items per page
            $currentPage, // Current page
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()] // Options for URL generation
        );
    }

    /**
     * Generate dynamic flight results when no matches are found.
     */
    protected function generateDynamicFlights(string $origin, string $destination): \Illuminate\Support\Collection
    {
        $dynamicFlights = [];
        $originName = ucwords(explode(',', $origin)[0]);
        $destName = ucwords(explode(',', $destination)[0]);

        $airlines = [
            ['name' => 'Qatar Airways', 'logo' => $this->airlineLogoPool['Qatar Airways']],
            ['name' => 'Emirates', 'logo' => $this->airlineLogoPool['Emirates']],
            ['name' => 'Singapore Airlines', 'logo' => $this->airlineLogoPool['Singapore Airlines']],
            ['name' => 'ANA', 'logo' => $this->airlineLogoPool['ANA']],
            ['name' => 'Lufthansa', 'logo' => $this->airlineLogoPool['Lufthansa']],
            ['name' => 'Etihad Airways', 'logo' => $this->airlineLogoPool['Etihad Airways']],
        ];

        srand(crc32(strtolower($origin . $destination)));

        for ($i = 1; $i <= 8; $i++) {
            $airline = $airlines[array_rand($airlines)];
            $price = rand(400, 1500);
            $hour = rand(0, 23);
            $duration = rand(6, 16);

            $dynamicFlights[] = [
                'id' => 'df_' . $i . '_' . base64_encode($origin . '|' . $destination),
                'airline' => $airline['name'],
                'airline_logo' => $airline['logo'],
                'flight_number' => strtoupper(substr($originName, 0, 1) . substr($destName, 0, 1)) . ' ' . rand(100, 999),
                'origin' => strtoupper(substr($originName, 0, 3)),
                'origin_city' => $originName,
                'origin_country' => 'Search Origin',
                'destination' => strtoupper(substr($destName, 0, 3)),
                'destination_city' => $destName,
                'destination_country' => 'Search Destination',
                'departure_time' => str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00',
                'arrival_time' => str_pad(($hour + $duration) % 24, 2, '0', STR_PAD_LEFT) . ':00',
                'duration' => $duration . 'h 00m',
                'price' => $price,
                'original_price' => $price + rand(100, 300),
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => rand(0, 1),
                'aircraft' => 'Boeing 787 Dreamliner',
                'baggage' => '23kg checked',
            ];
        }

        srand();

        return collect($dynamicFlights);
    }

    /**
     * Get detailed information about a specific flight.
     */
    public function getFlightDetail(string|int $flightId): ?array
    {
        $flight = null;

        // Check if it's a dynamic ID
        if (is_string($flightId) && str_starts_with($flightId, 'df_')) {
            try {
                // ID format: df_[index]_[base64_origin|destination]
                $parts = explode('_', $flightId);
                if (count($parts) >= 3) {
                    $decoded = base64_decode($parts[2]);
                    if ($decoded && str_contains($decoded, '|')) {
                        [$origin, $destination] = explode('|', $decoded);
                        $dynamicFlights = $this->generateDynamicFlights($origin, $destination);
                        $flight = $dynamicFlights->first(fn($f) => $f['id'] == $flightId);
                    }
                }
            } catch (\Exception $e) {
                // Fallback to null
            }
        } else {
            $flights = $this->getMockFlights();
            foreach ($flights as $f) {
                if ($f['id'] == $flightId) {
                    $flight = $f;
                    break;
                }
            }
        }

        if ($flight) {
            // Add extra detail fields
            $flight['fare_breakdown'] = [
                'base_fare' => round($flight['price'] * 0.75, 2),
                'taxes' => round($flight['price'] * 0.15, 2),
                'surcharges' => round($flight['price'] * 0.07, 2),
                'service_fee' => round($flight['price'] * 0.03, 2),
            ];
            $flight['flight_details'] = [
                'departure_terminal' => 'Terminal ' . rand(1, 3),
                'arrival_terminal' => 'Terminal ' . rand(1, 4),
                'meal' => 'Complimentary meals and beverages',
                'entertainment' => 'Personal in-flight entertainment system',
                'wifi' => 'Available (paid)',
                'power' => 'USB and AC power at every seat',
            ];
            return $flight;
        }

        return null;
    }
}
