<?php

namespace Bronk\CodeAnalyzer\Providers;

use Illuminate\Support\ServiceProvider;
use Bronk\CodeAnalyzer\Services\OllamaService;

class CodeAnalyzerServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}

	public function boot(): void
	{
		$this->app->when(OllamaService::class)
			->needs('$uri')
			->give(config('services.ollama.uri'));
	}
}
