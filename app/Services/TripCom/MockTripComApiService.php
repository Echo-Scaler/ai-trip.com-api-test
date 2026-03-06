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
                ['name' => 'The Grand Sakura', 'city' => 'Tokyo', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80'],
                ['name' => 'Marina Bay Sands', 'city' => 'Singapore', 'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80'],
                ['name' => 'Riverside Boutique', 'city' => 'Bangkok', 'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80'],
                ['name' => 'Heritage Hotel', 'city' => 'Hanoi', 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80'],
                ['name' => 'Sky Tower Hotel', 'city' => 'Seoul', 'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80'],
                ['name' => 'Serenity Villas', 'city' => 'Bali', 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80'],
                ['name' => 'Ocean View Resort', 'city' => 'Phuket', 'image' => 'https://images.unsplash.com/photo-1584132967334-10e028ae8757?w=800&q=80'],
                ['name' => 'Central Plaza', 'city' => 'Hong Kong', 'image' => 'https://images.unsplash.com/photo-1542314831-c6a4d14b434b?w=800&q=80'],
                ['name' => 'Imperial Palace', 'city' => 'Taipei', 'image' => 'https://images.unsplash.com/photo-1596436889106-be35e843f974?w=800&q=80'],
                ['name' => 'Oasis Retreat', 'city' => 'Dubai', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800&q=80'],
            ];

            $allHotels = [];
            $amenitiesPool = ['Free WiFi', 'Pool', 'Spa', 'Restaurant', 'Gym', 'Bar', 'Room Service', 'Airport Shuttle', 'Yoga Studio', 'Ocean View', 'Casino', 'Free Breakfast'];

            for ($i = 1; $i <= 40; $i++) {
                $base = $baseHotels[array_rand($baseHotels)];
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
                    'rating' => round(rand(35, 50) / 10, 1),
                    'stars' => rand(3, 5),
                    'price_per_night' => $price,
                    'original_price' => rand(0, 1) ? $price + rand(20, 100) : $price,
                    'currency' => 'USD',
                    'image_url' => $base['image'],
                    'amenities' => $amenities,
                    'description' => 'A wonderful stay at ' . $base['name'] . ' located in ' . $base['city'] . '. Enjoy premium amenities and world-class service.',
                    'latitude' => round(rand(-9000, 9000) / 100, 4),
                    'longitude' => round(rand(-18000, 18000) / 100, 4),
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
                ['code' => 'NRT', 'city' => 'Tokyo'],
                ['code' => 'SIN', 'city' => 'Singapore'],
                ['code' => 'BKK', 'city' => 'Bangkok'],
                ['code' => 'ICN', 'city' => 'Seoul'],
                ['code' => 'HKG', 'city' => 'Hong Kong'],
                ['code' => 'DPS', 'city' => 'Bali'],
                ['code' => 'DXB', 'city' => 'Dubai'],
                ['code' => 'SGN', 'city' => 'Ho Chi Minh'],
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
                    'destination' => $destination['code'],
                    'destination_city' => $destination['city'],
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

        // Filter by city if provided
        if (!empty($params['city'])) {
            $city = strtolower($params['city']);
            $hotels = $hotels->filter(function ($hotel) use ($city) {
                return str_contains(strtolower($hotel['city']), $city)
                    || str_contains(strtolower($hotel['name']), $city);
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
            $origin = strtoupper($params['origin']);
            $flights = $flights->filter(function ($flight) use ($origin) {
                return str_contains(strtoupper($flight['origin']), $origin)
                    || str_contains(strtoupper($flight['origin_city']), $origin);
            });
        }

        // Filter by destination
        if (!empty($params['destination'])) {
            $destination = strtoupper($params['destination']);
            $flights = $flights->filter(function ($flight) use ($destination) {
                return str_contains(strtoupper($flight['destination']), $destination)
                    || str_contains(strtoupper($flight['destination_city']), $destination);
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
