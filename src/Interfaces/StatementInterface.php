<?php

namespace Msaaq\Nelc\Interfaces;

use Msaaq\Nelc\Common\Platform;

interface StatementInterface
{
    public function setPlatform(Platform $platform): self;

    public function getPlatform(): Platform;

    public function toArray(): array;
}
