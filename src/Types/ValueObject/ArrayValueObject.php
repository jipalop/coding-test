<?php

declare(strict_types=1);

namespace App\Types\ValueObject;

use Countable;
use function count;

abstract class ArrayValueObject implements Countable
{
    /** @var array */
    protected $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }


    public function count(): int
    {
        return count($this->items());
    }

    public function items(): array
    {
        return $this->items;
    }

    public function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->items) ? $this->items[$key] : $default;
    }

    public function set(string $key, $value): void
    {
        $this->items[$key] = $value;
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->items());
    }

    public function isEmpty(): bool
    {
        return empty($this->items());
    }
}
