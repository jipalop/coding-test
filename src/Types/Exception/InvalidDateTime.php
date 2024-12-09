<?php

declare(strict_types = 1);

namespace App\Types\Exception;

use App\Exceptions\CriticalException;
use App\Types\ValueObject\DateTimeValueObject;

final class InvalidDateTime extends CriticalException
{
    public static function wrongFormat(string $value): self
    {
        return new self(
            'Wrong date time format',
            0,
            null,
            [
                'value'       => $value,
                'format_date' => DateTimeValueObject::FORMAT
            ]
        );
    }
}
