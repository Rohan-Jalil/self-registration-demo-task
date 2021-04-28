<?php

namespace App\Repositories\Locations;

interface LocationRepositoryInterface
{
    /**
     * Converting address into geographic coordinates
     * @param array $data
     * @return mixed
     */
    public function getGeographicCoordinates(array $data);
}
