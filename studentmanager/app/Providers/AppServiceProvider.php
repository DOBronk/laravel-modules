<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FakeStore;
use App\Services\FakeStore\FakeStoreService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->when(FakeStoreService::class)
            ->needs('$uri')
            ->give(config('services.fake_store.uri'));
    }
}
