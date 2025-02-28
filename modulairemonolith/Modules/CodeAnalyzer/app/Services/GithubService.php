<?php

namespace Modules\CodeAnalyzer\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\CodeAnalyzer\Exceptions\GithubExceptions\ConflictException;
use Modules\CodeAnalyzer\Exceptions\GithubExceptions\ValidationException;
use Modules\CodeAnalyzer\Exceptions\GithubExceptions\ResourceNotFoundException;

class GithubService
{
    public function __construct(private readonly string $uri, private readonly string $key)
    {
    }

    /**
     * Recursively retrieve all files ending with .php from provided git tree
     * @param string $owner Repository owner
     * @param string $repo Repository
     * @param string $sha Optional: SHA code for tree (defaults to main)
     * @return array|null Returns an associative array with SHA codes to all blobs or returns null on failure
     */
    public function getPhpFilesFromTree(string $owner, string $repo, string $sha = "main"): array|null
    {
        $uri = "{$this->uri}/repos/{$owner}/{$repo}/git/trees/{$sha}";
        $http = $this->httpClient()->get($uri, ['recursive' => 1]);

        switch ($http->status()) {
            case 200:
                $response = $http->json()['tree'];
                return array_filter($response, function ($item) {
                    return $item['type'] === "blob" && str_ends_with($item['path'], '.php');
                });
            case 404:
                throw new ResourceNotFoundException('Resource not found!');
            case 409:
                throw new ConflictException('Conflict!');
            case 422:
                throw new ValidationException('Validation error!');
            default:
                throw new \Exception('Unkown status code');
        }
    }
    /**
     * Retrieve blob as a string from git repository
     * @param string $owner Repository owner
     * @param string $repo Repository
     * @param string $sha SHA code for blob
     * @return string|null Return blob as string or null on failure
     */
    public function getBlob(string $owner, string $repo, string $sha): string|null
    {
        $uri = "{$this->uri}/repos/{$owner}/{$repo}/git/blobs/{$sha}";
        $http = $this->httpClient()->get($uri);
        Log::info("Blob: {$sha} http: {$http}");
        $json = $http->json();
        if ($http->status() == 200 && array_key_exists('content', $json)) {
            return base64_decode($json['content']);
        }
    }
    /**
     * Summary of createIssue
     * @param string $owner
     * @param string $repo
     * @param string $title
     * @param string $body
     * @return bool
     */
    public function createIssue(string $owner, string $repo, string $title, string $body): bool
    {
        $uri = "{$this->uri}/repos/{$owner}/{$repo}/issues";
        $http = $this->httpClient()->post($uri, [
            'title' => $title,
            'body' => $body,
            'labels' => ['AI Generated Issue']
        ]);

        return $http->status() == 201;
    }
    private function httpClient(): PendingRequest
    {
        return Http::withHeaders(["Authorization" => "Bearer {$this->key}"]);
    }
}
