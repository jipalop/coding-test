<?php

declare(strict_types = 1);

namespace App\Modules\Shared\Domain\Bus\Query;

interface Response
{
    public function toPlain(): array;
}