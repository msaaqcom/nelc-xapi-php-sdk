<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class ProgressedStatement extends BaseStatement implements StatementInterface
{
    public bool $completed;

    public function toArray(): array
    {
        return [
            'verb' => [
                'id' => Verb::PROGRESSED->value,
                'display' => ['en-US' => 'progressed'],
            ],
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform->identifier,
                'language' => $this->language->value,
                'extensions' => $this->sharedExtensions(),
            ],
            'result' => [
                'completion' => $this->completed,
                'score' => [
                    'scaled' => $this->module->score->scale(),
                ],
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
