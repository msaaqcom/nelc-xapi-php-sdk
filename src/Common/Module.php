<?php

namespace Msaaq\Nelc\Common;

use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Enums\ObjectType;

class Module
{
    public string $url;

    public string $title;

    public string $description;

    public Score $score;

    public ActivityType $activityType;

    public Language $language;

    /**
     * Duration in seconds
     *
     * @var float|int
     */
    public float|int $duration;

    public function getDuration(): string
    {
        $seconds = round($this->duration);
        $hours = floor(round($seconds) / 3600);
        $mins = floor(round($seconds) / 60 % 60);
        $secs = floor(round($seconds) % 60);

        return "PT{$hours}H{$mins}M{$secs}S";
    }

    public function toArray(): array
    {
        return [
            'id' => $this->url,
            'definition' => [
                'name' => [$this->language->value => $this->title],
                'description' => [$this->language->value => $this->description],
                'type' => $this->activityType->value,
            ],
            'objectType' => ObjectType::ACTIVITY->value,
        ];
    }
}
