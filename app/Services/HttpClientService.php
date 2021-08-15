<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class HttpClientService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function request(string $verb, string $uri)
    {
        $response = $this->client->request($verb, $this->baseUrl . $uri);
        return json_decode((string) $response->getBody());
    }
}
