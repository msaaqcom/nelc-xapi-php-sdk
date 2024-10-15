<?php

namespace Msaaq\Nelc\Common;

use Msaaq\Nelc\Enums\Extension;

class BrowserInformation
{
    public string $family = '';

    public string $name = '';

    public string $version = '';

    public function toArray(): array
    {
        return [
            Extension::BROWSER_INFORMATION->value => [
                'code_name' => $this->family,
                'name' => $this->name,
                'version' => $this->version,
            ],
        ];
    }
}
