<?php

declare(strict_types = 1);

namespace App\Types\ValueObject;

abstract class IntegerValueObject
{
    protected int $value;

    final public function __construct(int $value)
    {
        $this->guard($value);
        $this->value = $value;
    }

    protected function guard(int $value): void
    {
    }

    public static function fromString(string $value): static
    {
        return new static((int) $value);
    }

    public function value(): int
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

    public function differentThan(self $other): bool
    {
        return $this->value() !== $other->value();
    }

    public function __toString()
    {
        return (string) $this->value();
    }
}
