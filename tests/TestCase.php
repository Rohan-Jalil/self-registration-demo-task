<?php

namespace Tests;

use App\Repositories\Locations\LocationRepositoryInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function mockGoogleGeocodingRepository()
    {
        $locationRepositoryInterface = Mockery::mock(LocationRepositoryInterface::class);
        $locationRepositoryInterface->shouldReceive('getGeographicCoordinates')
            ->andReturn([
                'lat' => 11.1235,
                'lng' => 12.1234
            ]);

        // load the mock into the IoC container
        $this->app->instance(LocationRepositoryInterface::class, $locationRepositoryInterface);
    }
}
