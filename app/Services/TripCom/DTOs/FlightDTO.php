<?php

namespace App\Services\TripCom\DTOs;

class FlightDTO
{
    public function __construct(
        public readonly int|string $id,
        public readonly string $airline,
        public readonly string $airlineLogo,
        public readonly string $flightNumber,
        public readonly string $origin,
        public readonly string $originCity,
        public readonly string $destination,
        public readonly string $destinationCity,
        public readonly string $departureTime,
        public readonly string $arrivalTime,
        public readonly string $duration,
        public readonly float $price,
        public readonly string $currency,
        public readonly string $cabinClass,
        public readonly int $stops,
        public readonly ?string $aircraft = null,
        public readonly ?float $originalPrice = null,
        public readonly ?string $baggage = null,
    ) {}

    /**
     * Create a FlightDTO from an API response array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            airline: $data['airline'] ?? '',
            airlineLogo: $data['airline_logo'] ?? '',
            flightNumber: $data['flight_number'] ?? '',
            origin: $data['origin'] ?? '',
            originCity: $data['origin_city'] ?? '',
            destination: $data['destination'] ?? '',
            destinationCity: $data['destination_city'] ?? '',
            departureTime: $data['departure_time'] ?? '',
            arrivalTime: $data['arrival_time'] ?? '',
            duration: $data['duration'] ?? '',
            price: (float) ($data['price'] ?? 0),
            currency: $data['currency'] ?? 'USD',
            cabinClass: $data['cabin_class'] ?? 'Economy',
            stops: (int) ($data['stops'] ?? 0),
            aircraft: $data['aircraft'] ?? null,
            originalPrice: $data['original_price'] ?? null,
            baggage: $data['baggage'] ?? null,
        );
    }

    /**
     * Convert to array for views.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'airline' => $this->airline,
            'airline_logo' => $this->airlineLogo,
            'flight_number' => $this->flightNumber,
            'origin' => $this->origin,
            'origin_city' => $this->originCity,
            'destination' => $this->destination,
            'destination_city' => $this->destinationCity,
            'departure_time' => $this->departureTime,
            'arrival_time' => $this->arrivalTime,
            'duration' => $this->duration,
            'price' => $this->price,
            'currency' => $this->currency,
            'cabin_class' => $this->cabinClass,
            'stops' => $this->stops,
            'aircraft' => $this->aircraft,
            'original_price' => $this->originalPrice,
            'baggage' => $this->baggage,
        ];
    }
}
