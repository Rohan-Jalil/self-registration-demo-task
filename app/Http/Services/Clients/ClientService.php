<?php

namespace App\Http\Services\Clients;

use App\Repositories\Clients\ClientRepositoryInterface;
use ErrorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ClientService
 * @package App\Http\Service
 */
class ClientService
{
    /**
     * @var ClientRepositoryInterface
     */
    private ClientRepositoryInterface $repository;

    /**
     * ClientService constructor.
     * @param ClientRepositoryInterface $repository
     */
    function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->repository->getAll();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ErrorException
     */
    public function store(array $data)
    {
        return $this->repository->store($data);
    }
}
