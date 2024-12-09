<?php

namespace App\Modules\Product\Domain;

use App\Modules\Shared\Domain\ProductId;

interface ProductRepository
{
    /** @throws ProductNotExists */
    public function find(ProductId $productId): Product;
}
