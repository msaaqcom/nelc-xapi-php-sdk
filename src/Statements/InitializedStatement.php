<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Enums\Extension;
use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class InitializedStatement extends BaseStatement implements StatementInterface
{
    public function toArray(): array
    {
        return [
            'verb' => [
                'id' => Verb::INITIALIZED->value,
                'display' => ['en-US' => 'initialized'],
            ],
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform->identifier,
                'language' => $this->language->value,
                'extensions' => $this->sharedExtensions(),
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
