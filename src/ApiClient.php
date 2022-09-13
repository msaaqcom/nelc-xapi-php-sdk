<?php

namespace Msaaq\Nelc;

use GuzzleHttp\Client as Http;
use GuzzleHttp\RequestOptions;

class ApiClient
{
    const STAGING_API_BASE_URL = 'https://lrs.nelc.gov.sa/staging-lrs/xapi/';

    const PRODUCTION_API_BASE_URL = 'https://lrs.nelc.gov.sa/lrs/xapi/';

    private Http $client;

    public function __construct(
        private readonly string $key,
        private readonly string $secret,
        private readonly bool $isSandbox = false,
    ) {
        $this->client = new Http([
            'base_uri' => $this->isSandbox ? self::STAGING_API_BASE_URL : self::PRODUCTION_API_BASE_URL,
            'auth' => [$this->key, $this->secret],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public static function new(): self
    {
        return new self(...func_get_args());
    }

    public function request(string $method, string $path, array $payload)
    {
        return $this->client->request($method, $path, [
            RequestOptions::JSON => $payload,
        ]);
    }
}
