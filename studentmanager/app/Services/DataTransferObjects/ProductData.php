<?php

namespace App\Services\DataTransferObjects;

use Illuminate\Support\Collection;

class ProductData
{
    public function __construct(
        public readonly int $id,
        public readonly string $description,
        public readonly float $price,
        public readonly string $unit,
        public readonly string $image,
        public readonly float $discount,
        public readonly bool $availability,
        public readonly string $brand,
        public readonly string $category,
        public readonly float $rating,
        public readonly ?Collection $reviews,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $reviews = null;

        if (array_key_exists('reviews', $data)) {
            $reviews = collect($data['reviews'])
                ->map(fn(array $data) => ReviewData::fromArray($data));
        }

        return new self(
            id: (int) $data['product_id'],
            description: $data['description'],
            price: (float) $data['price'],
            unit: $data['unit'],
            image: $data['image'],
            discount: (float) $data['discount'],
            availability: (bool) $data['availability'],
            brand: $data['brand'],
            category: $data['category'],
            rating: (float) $data['rating'],
            reviews: $reviews,
        );
    }
}
