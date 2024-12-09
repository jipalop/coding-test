<?php

namespace App\Modules\Product\Application\FindProductById;

use App\Modules\Shared\Domain\Bus\Query\Query;

class FindProductByIdQuery implements Query
{
    public function __construct(private readonly string $productId)
    {
    }

    public function productId(): string
    {
        return $this->productId;
    }
}
