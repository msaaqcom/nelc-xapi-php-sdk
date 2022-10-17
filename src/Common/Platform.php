<?php

namespace Msaaq\Nelc\Common;

use Msaaq\Nelc\Enums\Language;

class Platform
{
    public function __construct(
        public string $identifier,
        public string $name,
        public Language $language = Language::ARABIC,
        public array $nameInOtherLanguages = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => array_merge($this->nameInOtherLanguages, [
                $this->language->value => $this->name,
            ])
        ];
    }
}
