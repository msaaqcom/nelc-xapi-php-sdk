<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Common\BrowserInformation;
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\Extension;
use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class AttemptedStatement extends BaseStatement implements StatementInterface
{
    public BrowserInformation $browserInformation;

    public Module $parent;

    public bool $completed;

    public bool $succeeded;

    public int $attemptId;

    public function toArray(): array
    {
        return [
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'verb' => [
                'id' => Verb::ATTEMPTED->value,
                'display' => ['en-US' => 'attempted'],
            ],
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform,
                'language' => $this->language->value,
                'extensions' => array_merge($this->browserInformation->toArray(), [
                    Extension::ATTEMPT_ID->value => $this->attemptId,
                ]),
                'contextActivities' => [
                    'parent' => $this->parent->toArray(),
                ],
            ],
            'result' => [
                'completion' => $this->completed,
                'success' => $this->succeeded,
                'score' => $this->module->score->toArray(),
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
