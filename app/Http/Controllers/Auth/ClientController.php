<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClientRequest;
use App\Http\Services\Clients\ClientService;
use ErrorException;
use Illuminate\Http\JsonResponse;

/**
 * Class ClientController
 * @package App\Http\Controllers\Auth
 */
class ClientController extends Controller
{
    /**
     * @var ClientService
     */
    private ClientService $service;

    /**
     * ClientController constructor.
     * @param ClientService $service
     */
    function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success($this->service->getAll());
    }

    /**
     * @param CreateClientRequest $request
     * @return JsonResponse
     * @throws ErrorException
     */
    public function store(CreateClientRequest $request): JsonResponse
    {
        return $this->success($this->service->store($request->validated()));
    }
}
