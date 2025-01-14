<?php

namespace App\Services\Ollama;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Services\FakeStore\DataTransferObjects\ProductData;

class OllamaService
{
    public function __construct(private readonly string $uri)
    {
    }
    /**
     * Summary of products
     * @return \Illuminate\Support\Collection<ProductData>
     */
    public function products(): Collection
    {
        $products = Http::post("{$this->uri}/api/generate", [
            'model' => 'llama3.2',
            'prompt' => 'why is the sky blue?'
        ])->json();

        dd($products);
        return collect($products)
            ->map(fn(array $data) => ProductData::fromArray($data));
    }
}
