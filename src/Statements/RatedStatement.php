<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Common\Score;
use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class RatedStatement extends BaseStatement implements StatementInterface
{
    public Score $rate;

    public string $rateContent;

    public function toArray(): array
    {
        return [
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'verb' => [
                'id' => Verb::RATED->value,
                'display' => ['en-US' => 'rated'],
            ],
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform->identifier,
                'language' => $this->language->value,
                'extensions' => $this->sharedExtensions(),
            ],
            'result' => [
                'score' => $this->rate->toArray(),
                'response' => $this->rateContent,
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
