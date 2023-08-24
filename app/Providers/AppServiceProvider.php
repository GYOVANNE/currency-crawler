<?php

namespace App\Providers;

use App\Domains\ClientRequest\Adapters\ClientGuzzleRequestAdapter;
use App\Domains\ClientRequest\Ports\ClientHttpRequestPort;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientHttpRequestPort::class, ClientGuzzleRequestAdapter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
