<?php

namespace App\Repositories\Clients;

use ErrorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
    /**
     * @throws ErrorException
     */
    public function store(array $data);

    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator;

    /**
     * @param array $data
     * @return string[]
     */
    public function buildGetGeoCoordinatesParams(array $data): array;

    /**
     * @param array $data
     * @return mixed
     */
    public function getGeoCoordinates(array $data);
}
