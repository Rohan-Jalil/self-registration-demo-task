<?php

namespace App\Http\Handlers;

use App\Exceptions\ErrorException;
use App\Http\Transformers\Responses\ApiResponder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class HttpHandler
{
    use ApiResponder;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var array
     */
    protected array $config;

    /**
     * Headers for all request.
     *
     * @var array
     */
    protected array $headers = [
        'Content-Type'    => 'application/json',
        'Accept'          => 'application/json'
    ];

    /**
     * Network constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Concatenate network's domain with endpoint.
     *
     * @param $endpoint
     * @return string
     */
    public function buildUrl($endpoint): string
    {
        if(substr($endpoint,0,4) == 'http') {
            return $endpoint;
        }
        return trim($this->config['baseUrl'],'/') . '/' . trim($endpoint, '/');
    }

    /**
     * Call an endpoint in the network.
     *
     * @param $endpoint
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws ErrorException
     */
    public function call($endpoint, $method = 'GET', $parameters = [])
    {
        try {
            $response = $this->client->request($method, $this->buildUrl($endpoint), $parameters);
        } catch (GuzzleException $e) {
            throw new ErrorException('exception.api_error');
        }
        $body = $response->getBody()->getContents();
        return $this->responseDecoder($body);
    }

    /**
     * This function helps us to decode the response data received through API
     * @param $response
     * @return mixed
     */
    public function responseDecoder($response)
    {
        return json_decode($response,true);
    }
}
