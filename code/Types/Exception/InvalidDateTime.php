<?php

declare(strict_types = 1);

namespace App\Types\Exception;

use Exception;

final class InvalidDateTime extends Exception
{
    public static function wrongFormat(string $value): self
    {
        return new self(
            sprintf('Wrong date time format %s', $value),
            0,
            null
        );
    }
}
