<?php

namespace Msaaq\Nelc\Statements;

use Carbon\Carbon;
use Msaaq\Nelc\Common\Actor;
use Msaaq\Nelc\Common\Instructor;
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Interfaces\StatementInterface;

class BaseStatement
{
    public Actor $actor;

    public Instructor $instructor;

    public Language $language;

    public Module $module;

    public ?string $platform = null;

    public string $timestamp;

    public function setPlatform(string $platform): StatementInterface
    {
        $this->platform = $platform;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp
            ? Carbon::parse($this->timestamp)->toIso8601String()
            : Carbon::now()->toIso8601String();
    }
}
