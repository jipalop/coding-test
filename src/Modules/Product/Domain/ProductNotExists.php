<?php

declare(strict_types=1);

namespace App\Modules\Product\Domain;

use App\Exceptions\DomainException;
use App\Modules\Shared\Domain\ProductId;

final class ProductNotExists extends DomainException
{
    private const MESSAGE = 'Product does not exist';

    public static function withId(ProductId $productId): self
    {
        return new self(self::MESSAGE, 0, null, ['id' => $productId->value()]);
    }

}
