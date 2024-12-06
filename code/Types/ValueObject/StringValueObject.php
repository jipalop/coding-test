<?php

declare(strict_types = 1);

namespace App\Types\ValueObject;

abstract class StringValueObject
{
    /** @var string $value */
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equalsTo(self $other): bool
    {
        return $other->value() === $this->value;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function __toString()
    {
        return $this->value();
    }
}
