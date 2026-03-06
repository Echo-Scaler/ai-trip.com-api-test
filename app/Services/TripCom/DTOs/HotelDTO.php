<?php

namespace App\Services\TripCom\DTOs;

class HotelDTO
{
    public function __construct(
        public readonly int|string $id,
        public readonly string $name,
        public readonly string $address,
        public readonly string $city,
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
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            address: $data['address'] ?? '',
            city: $data['city'] ?? '',
            rating: (float) ($data['rating'] ?? 0),
            stars: (int) ($data['stars'] ?? 3),
            pricePerNight: (float) ($data['price_per_night'] ?? 0),
            currency: $data['currency'] ?? 'USD',
            imageUrl: $data['image_url'] ?? '',
            amenities: $data['amenities'] ?? [],
            description: $data['description'] ?? '',
            latitude: $data['latitude'] ?? null,
            longitude: $data['longitude'] ?? null,
            originalPrice: $data['original_price'] ?? null,
            reviewCount: $data['review_count'] ?? null,
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
