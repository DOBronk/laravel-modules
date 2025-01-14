<?php

namespace Modules\CodeAnalyzer\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaService
{
    public function __construct(private readonly string $uri)
    {
    }

    public function analyze(string $code): string
    {
        $response = Http::timeout(1800)->post("http://localhost:11434/api/generate", [
            'model' => 'deepseek-coder-v2:latest',
            'prompt' => 'Can you analyze the following php code: \n' . $code,
            'stream' => false,
        ])->json();

        return $response['response'];
    }

    public function findIssues(string $code): ?string
    {
        $response = Http::timeout(1800)->post("http://host.docker.internal:11434/api/generate", [
            'model' => 'qwen2.5-coder:14b',
            'prompt' => "can you tell me if this code uses proper SOLID and DRY principles and return the output as json " .
                ": {$code}",
            'format' => 'json',
            'stream' => false,
        ])->json();

        if (array_key_exists('response', $response)) {
            return $response['response'];
        } else {
            Log::info($response);
        }
    }
}
