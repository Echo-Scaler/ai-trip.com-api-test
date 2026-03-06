<?php

namespace App\Services\TripCom;

use App\Contracts\TripComApiContract;

class MockTripComApiService implements TripComApiContract
{
    /**
     * Mock hotel data — realistic sample hotels.
     */
    protected function getMockHotels(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'The Grand Sakura Hotel',
                'address' => '1-2-3 Marunouchi, Chiyoda-ku',
                'city' => 'Tokyo',
                'rating' => 4.8,
                'stars' => 5,
                'price_per_night' => 285.00,
                'original_price' => 350.00,
                'currency' => 'USD',
                'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
                'amenities' => ['Free WiFi', 'Pool', 'Spa', 'Restaurant', 'Gym', 'Bar', 'Room Service'],
                'description' => 'Experience luxury in the heart of Tokyo. The Grand Sakura Hotel offers breathtaking city views, world-class dining, and impeccable service. Steps away from Tokyo Station and the Imperial Palace.',
                'latitude' => 35.6812,
                'longitude' => 139.7671,
                'review_count' => 2847,
            ],
            [
                'id' => 2,
                'name' => 'Marina Bay Sands',
                'address' => '10 Bayfront Avenue',
                'city' => 'Singapore',
                'rating' => 4.7,
                'stars' => 5,
                'price_per_night' => 420.00,
                'original_price' => 520.00,
                'currency' => 'USD',
                'image_url' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80',
                'amenities' => ['Infinity Pool', 'Casino', 'Spa', 'Shopping Mall', 'Theater', 'Fine Dining'],
                'description' => 'An iconic destination for the world\'s most discerning travelers. Marina Bay Sands features the famous rooftop infinity pool with panoramic city views.',
                'latitude' => 1.2834,
                'longitude' => 103.8607,
                'review_count' => 5123,
            ],
            [
                'id' => 3,
                'name' => 'Riverside Boutique Resort',
                'address' => '456 Charoen Krung Road',
                'city' => 'Bangkok',
                'rating' => 4.5,
                'stars' => 4,
                'price_per_night' => 145.00,
                'original_price' => 189.00,
                'currency' => 'USD',
                'image_url' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80',
                'amenities' => ['Free WiFi', 'Pool', 'Restaurant', 'Spa', 'Airport Shuttle'],
                'description' => 'A charming boutique resort along the Chao Phraya River. Enjoy traditional Thai hospitality with modern amenities and stunning river views.',
                'latitude' => 13.7217,
                'longitude' => 100.5133,
                'review_count' => 1562,
            ],
            [
                'id' => 4,
                'name' => 'Hanoi Heritage Hotel',
                'address' => '12 Hang Bong Street, Old Quarter',
                'city' => 'Hanoi',
                'rating' => 4.3,
                'stars' => 4,
                'price_per_night' => 98.00,
                'original_price' => 130.00,
                'currency' => 'USD',
                'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
                'amenities' => ['Free WiFi', 'Restaurant', 'Bar', 'Laundry', 'Tour Desk'],
                'description' => 'Step into the charm of Hanoi\'s Old Quarter. This beautifully restored heritage hotel blends colonial architecture with Vietnamese warmth.',
                'latitude' => 21.0334,
                'longitude' => 105.8506,
                'review_count' => 987,
            ],
            [
                'id' => 5,
                'name' => 'Seoul Sky Tower Hotel',
                'address' => '300 Olympic-ro, Songpa-gu',
                'city' => 'Seoul',
                'rating' => 4.6,
                'stars' => 5,
                'price_per_night' => 310.00,
                'original_price' => 399.00,
                'currency' => 'USD',
                'image_url' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80',
                'amenities' => ['Free WiFi', 'Pool', 'Gym', 'Spa', 'Restaurant', 'Sky Lounge'],
                'description' => 'Soar above Seoul at the Sky Tower Hotel. Located in Songpa-gu, enjoy panoramic views of the city skyline and Lotte World from every room.',
                'latitude' => 37.5126,
                'longitude' => 127.1025,
                'review_count' => 2134,
            ],
            [
                'id' => 6,
                'name' => 'Bali Serenity Villas',
                'address' => 'Jl. Raya Ubud No. 88',
                'city' => 'Bali',
                'rating' => 4.9,
                'stars' => 5,
                'price_per_night' => 195.00,
                'original_price' => 260.00,
                'currency' => 'USD',
                'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80',
                'amenities' => ['Private Pool', 'Free WiFi', 'Yoga Studio', 'Organic Restaurant', 'Spa', 'Rice Terrace View'],
                'description' => 'Escape to paradise at Bali Serenity Villas. Surrounded by lush rice terraces, each villa offers a private pool and authentic Balinese luxury.',
                'latitude' => -8.5069,
                'longitude' => 115.2625,
                'review_count' => 1876,
            ],
        ];
    }

    /**
     * Mock flight data — realistic sample flights.
     */
    protected function getMockFlights(): array
    {
        return [
            [
                'id' => 1,
                'airline' => 'Singapore Airlines',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Singapore-Airlines-Logo.png',
                'flight_number' => 'SQ 872',
                'origin' => 'NRT',
                'origin_city' => 'Tokyo (Narita)',
                'destination' => 'SIN',
                'destination_city' => 'Singapore (Changi)',
                'departure_time' => '10:30',
                'arrival_time' => '17:05',
                'duration' => '7h 35m',
                'price' => 489.00,
                'original_price' => 620.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Airbus A380-800',
                'baggage' => '30kg checked + 7kg cabin',
            ],
            [
                'id' => 2,
                'airline' => 'ANA',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2023/01/ANA-Logo.png',
                'flight_number' => 'NH 843',
                'origin' => 'NRT',
                'origin_city' => 'Tokyo (Narita)',
                'destination' => 'BKK',
                'destination_city' => 'Bangkok (Suvarnabhumi)',
                'departure_time' => '11:00',
                'arrival_time' => '15:50',
                'duration' => '6h 50m',
                'price' => 385.00,
                'original_price' => 450.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Boeing 787-9',
                'baggage' => '23kg checked + 7kg cabin',
            ],
            [
                'id' => 3,
                'airline' => 'Korean Air',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Korean-Air-Logo.png',
                'flight_number' => 'KE 710',
                'origin' => 'ICN',
                'origin_city' => 'Seoul (Incheon)',
                'destination' => 'NRT',
                'destination_city' => 'Tokyo (Narita)',
                'departure_time' => '09:15',
                'arrival_time' => '11:30',
                'duration' => '2h 15m',
                'price' => 215.00,
                'original_price' => 280.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Airbus A330-300',
                'baggage' => '23kg checked + 10kg cabin',
            ],
            [
                'id' => 4,
                'airline' => 'Cathay Pacific',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Cathay-Pacific-Logo.png',
                'flight_number' => 'CX 520',
                'origin' => 'HKG',
                'origin_city' => 'Hong Kong',
                'destination' => 'DPS',
                'destination_city' => 'Bali (Ngurah Rai)',
                'departure_time' => '08:45',
                'arrival_time' => '13:20',
                'duration' => '4h 35m',
                'price' => 342.00,
                'original_price' => 410.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Airbus A350-900',
                'baggage' => '30kg checked + 7kg cabin',
            ],
            [
                'id' => 5,
                'airline' => 'Japan Airlines',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Japan-Airlines-Logo.png',
                'flight_number' => 'JL 735',
                'origin' => 'HND',
                'origin_city' => 'Tokyo (Haneda)',
                'destination' => 'HAN',
                'destination_city' => 'Hanoi (Noi Bai)',
                'departure_time' => '10:05',
                'arrival_time' => '14:25',
                'duration' => '5h 20m',
                'price' => 298.00,
                'original_price' => 365.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Boeing 787-8',
                'baggage' => '23kg checked + 7kg cabin',
            ],
            [
                'id' => 6,
                'airline' => 'Thai Airways',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Thai-Airways-Logo.png',
                'flight_number' => 'TG 661',
                'origin' => 'BKK',
                'origin_city' => 'Bangkok (Suvarnabhumi)',
                'destination' => 'SIN',
                'destination_city' => 'Singapore (Changi)',
                'departure_time' => '07:30',
                'arrival_time' => '10:55',
                'duration' => '2h 25m',
                'price' => 178.00,
                'original_price' => 220.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Boeing 777-300ER',
                'baggage' => '30kg checked + 7kg cabin',
            ],
            [
                'id' => 7,
                'airline' => 'Emirates',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2020/03/Emirates-Logo.png',
                'flight_number' => 'EK 318',
                'origin' => 'NRT',
                'origin_city' => 'Tokyo (Narita)',
                'destination' => 'DXB',
                'destination_city' => 'Dubai',
                'departure_time' => '21:45',
                'arrival_time' => '04:30+1',
                'duration' => '11h 45m',
                'price' => 725.00,
                'original_price' => 890.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Airbus A380-800',
                'baggage' => '35kg checked + 7kg cabin',
            ],
            [
                'id' => 8,
                'airline' => 'Vietnam Airlines',
                'airline_logo' => 'https://logos-world.net/wp-content/uploads/2023/01/Vietnam-Airlines-Logo.png',
                'flight_number' => 'VN 311',
                'origin' => 'SGN',
                'origin_city' => 'Ho Chi Minh City',
                'destination' => 'ICN',
                'destination_city' => 'Seoul (Incheon)',
                'departure_time' => '00:05',
                'arrival_time' => '07:30',
                'duration' => '5h 25m',
                'price' => 265.00,
                'original_price' => 310.00,
                'currency' => 'USD',
                'cabin_class' => 'Economy',
                'stops' => 0,
                'aircraft' => 'Airbus A350-900',
                'baggage' => '23kg checked + 7kg cabin',
            ],
        ];
    }

    /**
     * Search for hotels based on criteria.
     */
    public function searchHotels(array $params): array
    {
        $hotels = $this->getMockHotels();

        // Filter by city if provided
        if (!empty($params['city'])) {
            $city = strtolower($params['city']);
            $hotels = array_filter($hotels, function ($hotel) use ($city) {
                return str_contains(strtolower($hotel['city']), $city)
                    || str_contains(strtolower($hotel['name']), $city);
            });
        }

        return array_values($hotels);
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
    public function searchFlights(array $params): array
    {
        $flights = $this->getMockFlights();

        // Filter by origin
        if (!empty($params['origin'])) {
            $origin = strtoupper($params['origin']);
            $flights = array_filter($flights, function ($flight) use ($origin) {
                return str_contains(strtoupper($flight['origin']), $origin)
                    || str_contains(strtoupper($flight['origin_city']), $origin);
            });
        }

        // Filter by destination
        if (!empty($params['destination'])) {
            $destination = strtoupper($params['destination']);
            $flights = array_filter($flights, function ($flight) use ($destination) {
                return str_contains(strtoupper($flight['destination']), $destination)
                    || str_contains(strtoupper($flight['destination_city']), $destination);
            });
        }

        return array_values($flights);
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
