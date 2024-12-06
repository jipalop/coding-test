<?php

declare(strict_types = 1);

namespace App\Types\ValueObject;

use App\Types\Exception\InvalidDateTime;
use DateTimeImmutable;
use function Functions\date_time_immutable_to_mutable;
use function Functions\date_to_millis;
use function Functions\int_millis_to_date;

abstract class DateTimeValueObject
{
    public const FORMAT = 'Y-m-d H:i:s';

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

    /**
     * @throws InvalidDateTime
     */
    public static function fromStringOrNow(string $value): static
    {
        if ('now' === $value) {
            return new static(new DateTimeImmutable());
        }

        $dateTime = DateTimeImmutable::createFromFormat(self::FORMAT, $value);

        if (!$dateTime) {
            throw InvalidDateTime::wrongFormat($value);
        }

        return new static($dateTime);
    }

    public static function fromTimestamp(int $value): static
    {
        $dateTime = (new DateTimeImmutable())->setTimestamp($value);

        return new static($dateTime);
    }

    public static function fromMillis(int $millis): static
    {
        return new static(int_millis_to_date($millis));
    }

    public function equalsTo(self $other): bool
    {
        return $other->value()->getTimestamp() === $this->value()->getTimestamp();
    }

    public function beforeThan(self $other): bool
    {
        return $this->value()->getTimestamp() < $other->value()->getTimestamp();
    }

    public function format(string $format = self::FORMAT): string
    {
        return $this->value()->format($format);
    }

    public function toMillis(): int
    {
        return date_to_millis($this->value());
    }

    public function toMutable(): \DateTime
    {
        return date_time_immutable_to_mutable($this->value());
    }

    public function inSameYearAndMonth(DateTimeValueObject $datetime): bool
    {
        return $this->format('Y') === $datetime->format('Y') &&
            $this->format('m') === $datetime->format('m');
    }

    public function inPreviousYear(DateTimeValueObject $datetime): bool
    {
        return (int) $this->format('Y') < (int) $datetime->format('Y');
    }
}
