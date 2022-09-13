<?php

namespace Msaaq\Nelc;

use Exception;
use Msaaq\Nelc\Interfaces\StatementInterface;

class StatementClient
{
    const STATEMENTS_PATH = 'statements';

    private string $platform;

    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public static function setClient(ApiClient $client): self
    {
        return new self($client);
    }

    public function setPlatform(string $string): self
    {
        $this->platform = $string;

        return $this;
    }

    public function send(StatementInterface $statement)
    {
        $payload = $statement->setPlatform($this->platform)->toArray();

        try {
            $response = $this->apiClient->request('POST', self::STATEMENTS_PATH, $payload);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new Exception(sprintf('Request failed with status code %s', $statusCode), $statusCode);
        }

        return json_decode($response->getBody()->getContents(), true) ?? [];
    }
}
