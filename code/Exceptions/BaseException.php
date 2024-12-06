<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;
use Throwable;

abstract class BaseException extends Exception
{
    /** @var array */
    protected $extraItems = [];

    final public function __construct(string $message, int $code, ?Throwable $previous = null, array $extraItems = [])
    {
        $this->extraItems = $extraItems;
        parent::__construct($message, $code, $previous);
    }

    public static function withMessageAndExtraItems(string $message, array $extraItems): static
    {
        return new static($message, 0, null, $extraItems);
    }

    public function extraItems(): array
    {
        return $this->extraItems;
    }
}
