<?php

namespace App\Services\TripCom\DTOs;

class HotelDTO
{
    public function __construct(
        public readonly int|string $id,
        public readonly string $name,
        public readonly string $address,
        public readonly string $city,
        public readonly string $country,
        public readonly float $rating,
        public readonly int $stars,
        public readonly float $pricePerNight,
        public readonly string $currency,
        public readonly string $imageUrl,
        public readonly array $amenities,
        public readonly string $description,
        public readonly ?float $latitude = null,
        public readonly ?float $longitude = null,
        public readonly ?float $originalPrice = null,
        public readonly ?int $reviewCount = null,
    ) {}

    /**
     * Create a HotelDTO from an API response array.
     * Maps real Trip.com OpenAPI fields (PascalCase/Nested) to internal properties.
     */
    public static function fromArray(array $data): self
    {
        // Handle both simple snake_case (legacy/internal) and real Trip.com PascalCase
        return new self(
            id: $data['HotelID'] ?? $data['id'] ?? 0,
            name: $data['HotelName'] ?? $data['name'] ?? '',
            address: $data['Address'] ?? $data['address'] ?? '',
            city: $data['CityName'] ?? $data['city'] ?? '',
            country: $data['CountryName'] ?? $data['country'] ?? '',
            rating: (float) ($data['Rating'] ?? $data['rating'] ?? 0),
            stars: (int) ($data['StarRating'] ?? $data['stars'] ?? 3),
            pricePerNight: (float) ($data['PriceInfo']['Price'] ?? $data['price_per_night'] ?? 0),
            currency: $data['PriceInfo']['Currency'] ?? $data['currency'] ?? 'USD',
            imageUrl: $data['ImageUrl'] ?? $data['image_url'] ?? '',
            amenities: $data['Amenities'] ?? $data['amenities'] ?? [],
            description: $data['Description'] ?? $data['description'] ?? '',
            latitude: $data['Position']['Latitude'] ?? $data['latitude'] ?? null,
            longitude: $data['Position']['Longitude'] ?? $data['longitude'] ?? null,
            originalPrice: $data['PriceInfo']['OriginalPrice'] ?? $data['original_price'] ?? null,
            reviewCount: $data['ReviewInfo']['ReviewCount'] ?? $data['review_count'] ?? null,
        );
    }

    /**
     * Convert to array for views.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'rating' => $this->rating,
            'stars' => $this->stars,
            'price_per_night' => $this->pricePerNight,
            'currency' => $this->currency,
            'image_url' => $this->imageUrl,
            'amenities' => $this->amenities,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'original_price' => $this->originalPrice,
            'review_count' => $this->reviewCount,
        ];
    }
}
