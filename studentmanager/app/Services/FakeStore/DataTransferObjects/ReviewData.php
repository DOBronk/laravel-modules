<?php

namespace App\Services\FakeStore\DataTransferObjects;

class ReviewData
{
    public function __construct(
        public readonly int $user_id,
        public readonly int $rating,
        public readonly string $comment,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: (int) $data['user_id'],
            rating: (int) $data['rating'],
            comment: $data['comment']
        );
    }
}
