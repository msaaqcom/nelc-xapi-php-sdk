<?php

namespace Msaaq\Nelc\Statements;

use Msaaq\Nelc\Enums\Extension;
use Msaaq\Nelc\Enums\Verb;
use Msaaq\Nelc\Interfaces\StatementInterface;

class RegisteredStatement extends BaseStatement implements StatementInterface
{
    public string $duration = '';

    public string $learnerMobileNo = '';

    public string $learnerFullName = '';

    public string $learnerNationality = '';

    public string $dateOfBirth = '';

    public function toArray(): array
    {
        $extensions = $this->sharedExtensions();

        if ($this->duration) {
            $extensions[Extension::DURATION->value] = $this->duration;
        }

        if ($this->learnerMobileNo) {
            $extensions[Extension::LEARNER_MOBILE_NO->value] = $this->learnerMobileNo;
        }

        if ($this->learnerFullName) {
            $extensions[Extension::LEARNER_FULL_NAME->value] = $this->learnerFullName;
        }

        if ($this->learnerNationality) {
            $extensions[Extension::LEARNER_NATIONALITY->value] = $this->learnerNationality;
        }

        if ($this->dateOfBirth) {
            $extensions[Extension::DATE_OF_BIRTH->value] = $this->dateOfBirth;
        }

        return [
            'verb' => [
                'id' => Verb::REGISTERED->value,
                'display' => ['en-US' => 'registered'],
            ],
            'actor' => $this->actor->toArray(),
            'object' => $this->module->toArray(),
            'context' => [
                'instructor' => $this->instructor->toArray(),
                'platform' => $this->platform->identifier,
                'language' => $this->language->value,
                'extensions' => $extensions,
            ],
            'timestamp' => $this->getTimestamp(),
        ];
    }
}
