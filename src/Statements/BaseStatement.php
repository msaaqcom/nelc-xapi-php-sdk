<?php

namespace Msaaq\Nelc\Statements;

use Carbon\Carbon;
use Msaaq\Nelc\Common\Actor;
use Msaaq\Nelc\Common\Instructor;
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Common\Platform;
use Msaaq\Nelc\Enums\Extension;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Interfaces\StatementInterface;

class BaseStatement
{
    public Actor $actor;

    public Instructor $instructor;

    public Language $language;

    public Module $module;

    public Platform $platform;

    public string $timestamp;

    public function sharedExtensions(): array
    {
        return [
            Extension::PLATFORM->value => $this->platform->toArray()
        ];
    }

    public function setPlatform(Platform $platform): StatementInterface
    {
        $this->platform = $platform;

        return $this;
    }

    public function getPlatform(): Platform
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
