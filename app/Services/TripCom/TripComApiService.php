<?php

namespace App\Services\TripCom;

use App\Contracts\TripComApiContract;
use App\Services\TripCom\DTOs\FlightDTO;
use App\Services\TripCom\DTOs\HotelDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TripComApiService implements TripComApiContract
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $apiSecret;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('tripcom.base_url');
        $this->apiKey = config('tripcom.api_key');
        $this->apiSecret = config('tripcom.api_secret');
        $this->timeout = config('tripcom.timeout', 30);
    }

    /**
     * Build authentication headers for Trip.com API.
     */
    protected function getHeaders(): array
    {
        $timestamp = time();
        $signature = hash_hmac('sha256', $this->apiKey . $timestamp, $this->apiSecret);

        return [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'X-Api-Key' => $this->apiKey,
            'X-Timestamp' => (string) $timestamp,
            'X-Signature' => $signature,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Accept-Language' => config('tripcom.language', 'en'),
        ];
    }

    /**
     * Make an API request to Trip.com.
     */
    protected function request(string $method, string $endpoint, array $data = []): ?array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout($this->timeout)
                ->{$method}($this->baseUrl . $endpoint, $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Trip.com API error', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Trip.com API exception', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Search for hotels based on criteria.
     */
    public function searchHotels(array $params): array
    {
        $response = $this->request('post', '/hotel/search', [
            'city' => $params['city'] ?? '',
            'checkIn' => $params['check_in'] ?? '',
            'checkOut' => $params['check_out'] ?? '',
            'guests' => $params['guests'] ?? 1,
            'rooms' => $params['rooms'] ?? 1,
            'currency' => config('tripcom.currency', 'USD'),
            'language' => config('tripcom.language', 'en'),
        ]);

        if (!$response || !isset($response['data']['hotels'])) {
            return [];
        }

        return array_map(
            fn($hotel) => HotelDTO::fromArray($hotel)->toArray(),
            $response['data']['hotels']
        );
    }

    /**
     * Get detailed information about a specific hotel.
     */
    public function getHotelDetail(string|int $hotelId): ?array
    {
        $response = $this->request('get', "/hotel/{$hotelId}", [
            'currency' => config('tripcom.currency', 'USD'),
            'language' => config('tripcom.language', 'en'),
        ]);

        if (!$response || !isset($response['data'])) {
            return null;
        }

        return HotelDTO::fromArray($response['data'])->toArray();
    }

    /**
     * Search for flights based on criteria.
     */
    public function searchFlights(array $params): array
    {
        $response = $this->request('post', '/flight/search', [
            'origin' => $params['origin'] ?? '',
            'destination' => $params['destination'] ?? '',
            'departureDate' => $params['departure_date'] ?? '',
            'returnDate' => $params['return_date'] ?? null,
            'passengers' => $params['passengers'] ?? 1,
            'cabinClass' => $params['cabin_class'] ?? 'Economy',
            'currency' => config('tripcom.currency', 'USD'),
            'language' => config('tripcom.language', 'en'),
        ]);

        if (!$response || !isset($response['data']['flights'])) {
            return [];
        }

        return array_map(
            fn($flight) => FlightDTO::fromArray($flight)->toArray(),
            $response['data']['flights']
        );
    }

    /**
     * Get detailed information about a specific flight.
     */
    public function getFlightDetail(string|int $flightId): ?array
    {
        $response = $this->request('get', "/flight/{$flightId}", [
            'currency' => config('tripcom.currency', 'USD'),
            'language' => config('tripcom.language', 'en'),
        ]);

        if (!$response || !isset($response['data'])) {
            return null;
        }

        return FlightDTO::fromArray($response['data'])->toArray();
    }
}
