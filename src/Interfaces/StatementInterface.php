<?php

namespace Msaaq\Nelc\Interfaces;

interface StatementInterface
{
    public function setPlatform(string $platform): self;

    public function getPlatform(): ?string;

    public function toArray(): array;
}
