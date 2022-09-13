<?php

namespace Msaaq\Nelc;

use GuzzleHttp\Client as Http;
use Msaaq\Nelc\Interfaces\StatementInterface;

class ApiClient
{
    const STAGING_API_BASE_URL = 'https://lrs.nelc.gov.sa/staging-lrs/xapi/';

    const PRODUCTION_API_BASE_URL = 'https://lrs.nelc.gov.sa/lrs/xapi/';

    private Http $client;

    public function __construct(
        private readonly string $key,
        private readonly string $secret,
        private readonly string $platform,
        private readonly bool $isSandbox = false,
    ) {
        $this->client = new Http([
            'base_uri' => $this->isSandbox ? self::STAGING_API_BASE_URL : self::PRODUCTION_API_BASE_URL,
            'auth' => [$this->key, $this->secret],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public static function new(): self
    {
        return new self(...func_get_args());
    }

    public function sendStatement(StatementInterface $statement)
    {
        $payload = $statement->setPlatform($this->platform)->toArray();
        try {
            $response = $this->client->post('statements', [
                'json' => $payload,
            ]);

            return json_decode($response->getBody()->getContents(), true) ?? [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
