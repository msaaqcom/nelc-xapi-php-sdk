<?php

namespace Msaaq\Nelc\Common;

class Score
{
    public float|int $score;

    public float|int $min = 0;

    public float|int $max = 100;

    public function scale(): int|float
    {
        return ($this->score - $this->min) / ($this->max - $this->min);
    }

    public function toArray(): array
    {
        return [
            'scaled' => $this->scale(),
            'raw' => $this->score,
            'max' => $this->max,
            'min' => $this->min,
        ];
    }
}
