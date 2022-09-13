<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Common\BrowserInformation;
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class WatchedStatement extends BaseStatement implements StatementInterface
{
    public BrowserInformation $browserInformation;

    public Module $parent;

    public bool $completed;

    public function toArray(): array
    {
        return [
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'verb' => [
                'id' => Verb::WATCHED->value,
                'display' => ['en-US' => 'watched'],
            ],
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform,
                'language' => $this->language->value,
                'extensions' => $this->browserInformation->toArray(),
                'contextActivities' => [
                    'parent' => $this->parent->toArray(),
                ],
            ],
            'result' => [
                'completion' => $this->completed,
                'duration' => $this->module->getDuration(),
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
