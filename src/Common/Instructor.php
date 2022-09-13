<?php

namespace Msaaq\Nelc\Common;

class Instructor
{
    public string $email;

    public string $name;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'mbox' => "mailto:{$this->email}",
        ];
    }
}
