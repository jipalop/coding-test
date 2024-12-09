<?php

namespace App\Modules\Product\Application;

use App\Modules\Product\Domain\Product;
use App\Modules\Shared\Domain\Bus\Query\Response;

class ProductResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $description,
        private readonly int    $category,
        private readonly float  $price,
    )
    {
    }

    public static function fromProduct(
        Product $product
    ): OrderResponse
    {
        return new self(
            $product->id()->value(),
            $product->description()->value(),
            $product->category()->value(),
            $product->price()->value()
        );
    }

    public function toPlain(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'category' => $this->category,
            'price' => $this->price,
        ];
    }
}
