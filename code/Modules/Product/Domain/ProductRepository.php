<?php

namespace App\Modules\Product\Domain;

use App\Shared\Domain\ProductId;

interface ProductRepository
{
    /** @throws ProductNotExists */
    public function find(ProductId $productId): Product;
}