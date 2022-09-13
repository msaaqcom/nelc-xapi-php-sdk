<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\Extension;
use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class EarnedBaseStatement extends BaseStatement implements StatementInterface
{
    public Module $parent;

    public string $certificateUrl;

    public function toArray(): array
    {
        return [
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'verb' => [
                'id' => Verb::EARNED->value,
                'display' => ['en-US' => 'earned'],
            ],
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform,
                'language' => $this->language->value,
                'extensions' => $this->certificateUrl ? [
                    Extension::JWS_CERTIFICATE_LOCATION->value => $this->certificateUrl,
                ] : [],
                'contextActivities' => [
                    'parent' => $this->parent->toArray(),
                ],
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
