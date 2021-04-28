<?php

namespace App\Providers;

use App\Repositories\Clients\ClientRepository;
use App\Repositories\Clients\ClientRepositoryInterface;
use App\Repositories\Locations\GoogleGeocoding\GoogleGeocodingRepository;
use App\Repositories\Locations\LocationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, GoogleGeocodingRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
