<?php

namespace App\Services\TripCom;

use App\Contracts\TripComApiContract;

class MockTripComApiService implements TripComApiContract
{
    /**
     * Mock hotel data — generate realistic sample hotels if not in cache.
     */
    protected function getMockHotels(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('mock_hotels', 3600, function () {
            $baseHotels = [
                ['name' => 'The Grand Sakura', 'city' => 'Tokyo', 'country' => 'Japan', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80'],
                ['name' => 'Marina Bay Sands', 'city' => 'Singapore', 'country' => 'Singapore', 'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80'],
                ['name' => 'Riverside Boutique', 'city' => 'Bangkok', 'country' => 'Thailand', 'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80'],
                ['name' => 'Heritage Hotel', 'city' => 'Hanoi', 'country' => 'Vietnam', 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80'],
                ['name' => 'Sky Tower Hotel', 'city' => 'Seoul', 'country' => 'South Korea', 'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80'],
                ['name' => 'Serenity Villas', 'city' => 'Bali', 'country' => 'Indonesia', 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80'],
                ['name' => 'Ocean View Resort', 'city' => 'Phuket', 'country' => 'Thailand', 'image' => 'https://images.unsplash.com/photo-1584132967334-10e028ae8757?w=800&q=80'],
                ['name' => 'Central Plaza', 'city' => 'Hong Kong', 'country' => 'Hong Kong', 'image' => 'https://images.unsplash.com/photo-1542314831-c6a4d14b434b?w=800&q=80'],
                ['name' => 'Imperial Palace', 'city' => 'Taipei', 'country' => 'Taiwan', 'image' => 'https://images.unsplash.com/photo-1596436889106-be35e843f974?w=800&q=80'],
                ['name' => 'Oasis Retreat', 'city' => 'Dubai', 'country' => 'United Arab Emirates', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800&q=80'],
                ['name' => 'Indo Plaza', 'city' => 'Jakarta', 'country' => 'Indonesia', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?w=800&q=80'],
                ['name' => 'Petronas Suites', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'image' => 'https://images.unsplash.com/photo-1583417319070-4a69db38a482?w=800&q=80'],
                ['name' => 'Manila Heights', 'city' => 'Manila', 'country' => 'Philippines', 'image' => 'https://images.unsplash.com/photo-1518182170546-07661fd94144?w=800&q=80'],
                ['name' => 'The Ritz', 'city' => 'London', 'country' => 'United Kingdom', 'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=800&q=80'],
                ['name' => 'Empire State Hotel', 'city' => 'New York', 'country' => 'USA', 'image' => 'https://images.unsplash.com/photo-1496417263034-38ec4f0b665a?w=800&q=80'],
                ['name' => 'Eiffel View Stay', 'city' => 'Paris', 'country' => 'France', 'image' => 'https://images.unsplash.com/photo-1502602898657-3e917240a182?w=800&q=80'],
                ['name' => 'Sydney Opera View', 'city' => 'Sydney', 'country' => 'Australia', 'image' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=800&q=80'],
                ['name' => 'Colosseum Palace', 'city' => 'Rome', 'country' => 'Italy', 'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800&q=80'],
                ['name' => 'Berlin Mitte Stay', 'city' => 'Berlin', 'country' => 'Germany', 'image' => 'https://images.unsplash.com/photo-1560624052-449f5ddf0c31?w=800&q=80'],
                ['name' => 'Alps Lodge', 'city' => 'Zurich', 'country' => 'Switzerland', 'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800&q=80'],
                ['name' => 'Liberty Hotel', 'city' => 'Toronto', 'country' => 'Canada', 'image' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800&q=80'],
                ['name' => 'Prado View', 'city' => 'Madrid', 'country' => 'Spain', 'image' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=800&q=80'],
                ['name' => 'Sagrada Suites', 'city' => 'Barcelona', 'country' => 'Spain', 'image' => 'https://images.unsplash.com/photo-1583422409516-2895a77efded?w=800&q=80'],
                ['name' => 'Canal House', 'city' => 'Amsterdam', 'country' => 'Netherlands', 'image' => 'https://images.unsplash.com/photo-1512470876302-972faa2aa9a4?w=800&q=80'],
                ['name' => 'Charles Bridge Hotel', 'city' => 'Prague', 'country' => 'Czech Republic', 'image' => 'https://images.unsplash.com/photo-1519677100203-ad0382b629e4?w=800&q=80'],
                ['name' => 'Vienna Royal', 'city' => 'Vienna', 'country' => 'Austria', 'image' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?w=800&q=80'],
                ['name' => 'Acropolis Stay', 'city' => 'Athens', 'country' => 'Greece', 'image' => 'https://images.unsplash.com/photo-1503152394-c57de29ff10b?w=800&q=80'],
                ['name' => 'Belem Palace', 'city' => 'Lisbon', 'country' => 'Portugal', 'image' => 'https://images.unsplash.com/photo-1558190067-d0b4273bc477?w=800&q=80'],
                ['name' => 'Bosphorus Boutique', 'city' => 'Istanbul', 'country' => 'Turkey', 'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=800&q=80'],
                ['name' => 'Golden Gate Lodge', 'city' => 'San Francisco', 'country' => 'USA', 'image' => 'https://images.unsplash.com/photo-1449034446853-66c86144b0ad?w=800&q=80'],
                ['name' => 'Hollywood Stay', 'city' => 'Los Angeles', 'country' => 'USA', 'image' => 'https://images.unsplash.com/photo-1444723121867-7a241cacace9?w=800&q=80'],
                ['name' => 'Ocean Drive Hotel', 'city' => 'Miami', 'country' => 'USA', 'image' => 'https://images.unsplash.com/photo-1506146332389-18140dc7b2fb?w=800&q=80'],
                ['name' => 'Zocalo Palace', 'city' => 'Mexico City', 'country' => 'Mexico', 'image' => 'https://images.unsplash.com/photo-1518105779142-d975fb23a3db?w=800&q=80'],
                ['name' => 'Copacabana View', 'city' => 'Rio de Janeiro', 'country' => 'Brazil', 'image' => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?w=800&q=80'],
                ['name' => 'Andes Retreat', 'city' => 'Buenos Aires', 'country' => 'Argentina', 'image' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?w=800&q=80'],
                ['name' => 'Cape View Hotel', 'city' => 'Cape Town', 'country' => 'South Africa', 'image' => 'https://images.unsplash.com/photo-1580619305218-8423a7ef79b4?w=800&q=80'],
                ['name' => 'Nile Palace', 'city' => 'Cairo', 'country' => 'Egypt', 'image' => 'https://images.unsplash.com/photo-1572252009286-268acec5ca0a?w=800&q=80'],
                ['name' => 'Medina Suites', 'city' => 'Marrakech', 'country' => 'Morocco', 'image' => 'https://images.unsplash.com/photo-1548013146-72479768bbaa?w=800&q=80'],
                ['name' => 'Harbour View', 'city' => 'Melbourne', 'country' => 'Australia', 'image' => 'https://images.unsplash.com/photo-1545044846-351ba102b4d5?w=800&q=80'],
                ['name' => 'Sky City Stay', 'city' => 'Auckland', 'country' => 'New Zealand', 'image' => 'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?w=800&q=80'],
            ];

            $cityCoords = [
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
            ];

            $allHotels = [];
            $amenitiesPool = ['Free WiFi', 'Pool', 'Spa', 'Restaurant', 'Gym', 'Bar', 'Room Service', 'Airport Shuttle', 'Yoga Studio', 'Ocean View', 'Casino', 'Free Breakfast'];

            for ($i = 1; $i <= 100; $i++) {
                $base = $baseHotels[array_rand($baseHotels)];
                $coords = $cityCoords[$base['city']];

                $price = rand(80, 500);

                // Shuffle and pick 4-6 random amenities
                $shuffleAmenities = $amenitiesPool;
                shuffle($shuffleAmenities);
                $amenities = array_slice($shuffleAmenities, 0, rand(4, 6));

                $allHotels[] = [
                    'id' => $i,
                    'name' => $base['name'] . ($i > 10 ? ' ' . rand(1, 9) : ''),
                    'address' => rand(10, 999) . ' Main Street, Central District',
                    'city' => $base['city'],
                    'country' => $base['country'],
                    'rating' => round(rand(35, 50) / 10, 1),
                    'stars' => rand(3, 5),
                    'price_per_night' => $price,
                    'original_price' => rand(0, 1) ? $price + rand(20, 100) : $price,
                    'currency' => 'USD',
                    'image_url' => $base['image'],
                    'amenities' => $amenities,
                    'description' => 'A wonderful stay at ' . $base['name'] . ' located in ' . $base['city'] . '. Enjoy premium amenities and world-class service.',
                    'latitude' => $coords['lat'] + (rand(-100, 100) / 1000), // Random offset within city
                    'longitude' => $coords['lng'] + (rand(-100, 100) / 1000),
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
                ['name' => 'Singapore Airlines', 'logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Singapore-Airlines-Logo.png'],
                ['name' => 'ANA', 'logo' => 'https://logos-world.net/wp-content/uploads/2023/01/ANA-Logo.png'],
                ['name' => 'Korean Air', 'logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Korean-Air-Logo.png'],
                ['name' => 'Cathay Pacific', 'logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Cathay-Pacific-Logo.png'],
                ['name' => 'Japan Airlines', 'logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Japan-Airlines-Logo.png'],
                ['name' => 'Thai Airways', 'logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Thai-Airways-Logo.png'],
                ['name' => 'Emirates', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/03/Emirates-Logo.png'],
                ['name' => 'Vietnam Airlines', 'logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Vietnam-Airlines-Logo.png'],
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

        // Filter by query (searches name, city, country)
        if (!empty($params['city'])) {
            $input = strtolower(trim($params['city']));
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
     * Get detailed information about a specific hotel.
     */
    public function getHotelDetail(string|int $hotelId): ?array
    {
        $hotels = $this->getMockHotels();

        foreach ($hotels as $hotel) {
            if ($hotel['id'] == $hotelId) {
                // Add extra detail fields for the detail view
                $hotel['rooms'] = [
                    [
                        'name' => 'Deluxe Double Room',
                        'price' => $hotel['price_per_night'],
                        'max_guests' => 2,
                        'bed_type' => 'King Bed',
                        'size' => '35 m²',
                        'includes' => ['Breakfast', 'Free Cancellation'],
                    ],
                    [
                        'name' => 'Premium Suite',
                        'price' => $hotel['price_per_night'] * 1.6,
                        'max_guests' => 3,
                        'bed_type' => 'King Bed + Sofa Bed',
                        'size' => '55 m²',
                        'includes' => ['Breakfast', 'Lounge Access', 'Free Cancellation', 'Late Checkout'],
                    ],
                    [
                        'name' => 'Executive Family Room',
                        'price' => $hotel['price_per_night'] * 1.3,
                        'max_guests' => 4,
                        'bed_type' => '2 Queen Beds',
                        'size' => '45 m²',
                        'includes' => ['Breakfast', 'Free Cancellation'],
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
                return $hotel;
            }
        }

        return null;
    }

    /**
     * Search for flights based on criteria.
     */
    public function searchFlights(array $params)
    {
        $flights = collect($this->getMockFlights());

        // Filter by origin
        if (!empty($params['origin'])) {
            $input = strtolower(trim($params['origin']));
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
        if (!empty($params['destination'])) {
            $input = strtolower(trim($params['destination']));
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
     * Get detailed information about a specific flight.
     */
    public function getFlightDetail(string|int $flightId): ?array
    {
        $flights = $this->getMockFlights();

        foreach ($flights as $flight) {
            if ($flight['id'] == $flightId) {
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
        }

        return null;
    }
}
