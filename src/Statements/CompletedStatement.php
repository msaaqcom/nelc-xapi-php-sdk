<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Common\BrowserInformation;
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class CompletedStatement extends BaseStatement implements StatementInterface
{
    public BrowserInformation|null $browserInformation = null;

    public Module|null $parent = null;

    public function toArray(): array
    {
        return [
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'verb' => [
                'id' => Verb::COMPLETED->value,
                'display' => ['en-US' => 'completed'],
            ],
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform,
                'language' => $this->language->value,
                'extensions' => $this->browserInformation ? $this->browserInformation->toArray() : [],
                'contextActivities' => $this->parent ? [
                    'parent' => $this->parent->toArray(),
                ] : [],
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
