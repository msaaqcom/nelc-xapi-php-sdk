<?php

namespace Msaaq\Nelc\Interfaces;

interface StatementInterface
{
    public function setPlatform(string $platform): self;

    public function toArray(): array;
}
