<?php

declare(strict_types = 1);

namespace App\Types\ValueObject;

abstract class FloatValueObject
{
    protected float $value;

    final public function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new static((float) $value);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equalsTo(self $other): bool
    {
        return $other->value() === $this->value;
    }

    public function greaterThan(self $other): bool
    {
        return $this->value() > $other->value();
    }

    public function lessThan(self $other): bool
    {
        return $this->value() < $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public static function fromInteger(int $value): static
    {
        return new static((float) ($value / 100));
    }

    public function toInteger(): int
    {
        return (int) ($this->value * 100);
    }
}
