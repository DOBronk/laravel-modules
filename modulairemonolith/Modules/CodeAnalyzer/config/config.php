<?php

return [
    'name' => 'CodeAnalyzer',
    'api_uri' => env('CODEANALYZER_API_URI', false),
    'gh_uri' => env('GITHUB_API_URI', false),
    'gh_key' => env("GITHUB_API_KEY", false)
];
