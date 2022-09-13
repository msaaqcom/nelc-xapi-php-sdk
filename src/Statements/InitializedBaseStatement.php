<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class InitializedBaseStatement extends BaseStatement implements StatementInterface
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
                'platform' => $this->platform,
                'language' => $this->language->value,
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
