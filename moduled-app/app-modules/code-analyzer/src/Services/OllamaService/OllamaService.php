<?php

namespace Bronk\CodeAnalyzer\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    public function __construct(private readonly string $uri)
    {
    }

    public function getResponse(string $prompt): string
    {
        $response = Http::post("{$this->uri}/api/generate", [
            'model' => 'llama3.2',
            'prompt' => $prompt,
            'stream' => false,
        ])->json();

        return $response['response'];
    }

}