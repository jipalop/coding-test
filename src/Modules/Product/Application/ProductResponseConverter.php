<?php

declare(strict_types=1);

namespace App\Modules\Product\Application;


use App\Modules\Product\Domain\Product;

class ProductResponseConverter
{
    public function __invoke(Product $product): OrderResponse
    {
        return $this->toResponse($product);
    }

    private function toResponse(Product $product): OrderResponse
    {
        return OrderResponse::fromProduct($product);
    }
}
