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
        public readonly string $originCountry,
        public readonly string $destinationCountry,
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
     * Maps real Trip.com OpenAPI fields (PascalCase/Nested) to internal properties.
     */
    public static function fromArray(array $data): self
    {
        // Handle both simple snake_case (legacy/internal) and real Trip.com PascalCase
        return new self(
            id: $data['FlightID'] ?? $data['id'] ?? 0,
            airline: $data['AirlineName'] ?? $data['airline'] ?? '',
            airlineLogo: $data['AirlineLogoUrl'] ?? $data['airline_logo'] ?? '',
            flightNumber: $data['FlightNo'] ?? $data['flight_number'] ?? '',
            origin: $data['OriginCityCode'] ?? $data['origin'] ?? '',
            originCity: $data['OriginCityName'] ?? $data['origin_city'] ?? '',
            destination: $data['DestCityCode'] ?? $data['destination'] ?? '',
            destinationCity: $data['DestCityName'] ?? $data['destination_city'] ?? '',
            originCountry: $data['OriginCountryName'] ?? $data['origin_country'] ?? '',
            destinationCountry: $data['DestCountryName'] ?? $data['destination_country'] ?? '',
            departureTime: $data['DepartureInfo']['Time'] ?? $data['departure_time'] ?? '',
            arrivalTime: $data['ArrivalInfo']['Time'] ?? $data['arrival_time'] ?? '',
            duration: $data['Duration'] ?? $data['duration'] ?? '',
            price: (float) ($data['PriceInfo']['Price'] ?? $data['price'] ?? 0),
            currency: $data['PriceInfo']['Currency'] ?? $data['currency'] ?? 'USD',
            cabinClass: $data['CabinClass'] ?? $data['cabin_class'] ?? 'Economy',
            stops: (int) ($data['Stops'] ?? 0),
            aircraft: $data['AircraftName'] ?? $data['aircraft'] ?? null,
            originalPrice: $data['PriceInfo']['OriginalPrice'] ?? $data['original_price'] ?? null,
            baggage: $data['BaggageInfo']['CheckedBaggage'] ?? $data['baggage'] ?? null,
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
            'origin_country' => $this->originCountry,
            'destination' => $this->destination,
            'destination_city' => $this->destinationCity,
            'destination_country' => $this->destinationCountry,
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
