<?php

declare(strict_types = 1);

namespace App\Types\ValueObject;

use App\Types\Exception\InvalidDateTime;
use DateTimeImmutable;

abstract class DateTimeValueObject
{
    public const FORMAT = 'Y-m-d';

    protected DateTimeImmutable $value;

    final public function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    /**
     * @throws InvalidDateTime
     */
    public static function fromString(string $value): static
    {
        $dateTime = DateTimeImmutable::createFromFormat(self::FORMAT, $value);

        if (!$dateTime) {
            throw InvalidDateTime::wrongFormat($value);
        }

        return new static($dateTime);
    }
}
