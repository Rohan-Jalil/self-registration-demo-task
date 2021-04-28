<?php

namespace App\Repositories\Locations\GoogleGeocoding;

use App\Exceptions\ErrorException;
use App\Exceptions\MessageException;
use App\Http\Handlers\HttpHandler;
use App\Repositories\Locations\LocationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GoogleGeocodingRepository extends HttpHandler implements LocationRepositoryInterface
{
    private array $parameters = [];

    public function __construct()
    {
        parent::__construct();
        $this->config = config('services.googlegeocoding');
        $this->validateConfig();
        $this->parameters = [
            'key' => $this->config['apiKey'],
            'headers' => [
                'Referer' => 'https://developers-dot-devsite-v2-prod.appspot.com/',
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];
    }

    private function validateConfig(): void
    {
        if (!isset($this->config)) {
            $this->failure('', trans('exception.invalid_config'), Response::HTTP_BAD_REQUEST);
        }

        if (!isset($this->config['baseUrl']) || empty($this->config['baseUrl'])) {
            $this->failure('', trans('exception.invalid_base_url'), Response::HTTP_BAD_REQUEST);
        }

        if (!isset($this->config['apiKey']) || empty($this->config['apiKey'])) {
            $this->failure('', trans('exception.invalid_api_key'), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Converting address into geographic coordinates
     * @param array $data
     * @return array|JsonResponse|null
     * @throws ErrorException
     * @throws MessageException
     */
    public function getGeographicCoordinates(array $data): array
    {
        $response = $this->call('geocode/json', 'GET', $this->prepareParams($data));
        $result = null;
        switch ($response['status']) {
            case 'OK':
                $location = $response['results']['geometry']['location'];
                $result = [
                    'lat' => $location['lat'],
                    'lng' => $location['lng']
                ];
                break;
            case 'ZERO_RESULTS':
            case 'OVER_DAILY_LIMIT':
            case 'OVER_QUERY_LIMIT':
            case 'REQUEST_DENIED':
            case 'INVALID_REQUEST':
            case 'UNKNOWN_ERROR':
                throw new MessageException($response['error_message']);
        }
        return $result;
    }

    private function prepareParams(array $data): array
    {
        return array_merge($this->parameters, [
            'query' => [
                'address' => $data['address']
            ]
        ]);
    }
}
