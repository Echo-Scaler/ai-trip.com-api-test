<?php

namespace App\Contracts;

interface TripComApiContract
{
    /**
     * Search for hotels based on criteria.
     *
     * @param array $params ['city', 'check_in', 'check_out', 'guests', 'rooms']
     * @return array
     */
    public function searchHotels(array $params): array;

    /**
     * Get detailed information about a specific hotel.
     *
     * @param string|int $hotelId
     * @return array|null
     */
    public function getHotelDetail(string|int $hotelId): ?array;

    /**
     * Search for flights based on criteria.
     *
     * @param array $params ['origin', 'destination', 'departure_date', 'return_date', 'passengers', 'cabin_class']
     * @return array
     */
    public function searchFlights(array $params): array;

    /**
     * Get detailed information about a specific flight.
     *
     * @param string|int $flightId
     * @return array|null
     */
    public function getFlightDetail(string|int $flightId): ?array;
}
