<?php

namespace App\Modules\Product\Domain;

interface ProductRepository
{
    /** @throws ProductNotExists */
    public function find(ProductId $productId): Product;
}