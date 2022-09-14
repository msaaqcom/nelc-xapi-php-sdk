<?php

namespace Msaaq\Nelc\Common;

use Msaaq\Nelc\Enums\ObjectType;

class Actor
{
    public string $email;

    public string $national_id;

    public function toArray(): array
    {
        return [
            'mbox' => "mailto:{$this->email}",
            'name' => $this->national_id,
            'objectType' => ObjectType::AGENT->value,
        ];
    }
}
