<?php

namespace App\Services\FakeStore;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Services\DataTransferObjects\ProductData;

class FakeStoreService
{
    public function __construct(private readonly string $uri)
    {
    }

    public function products(): Collection
    {
        $products = Http::get("{$this->uri}/api/products")->json();

        return collect($products)
            ->map(fn(array $data) => ProductData::fromArray($data));
    }
}
