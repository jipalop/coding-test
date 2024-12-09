<?php

namespace App\Modules\Product\Application;

use App\Modules\Product\Domain\Product;
use App\Modules\Shared\Domain\Bus\Query\Response;

readonly class ProductResponse implements Response
{
    public function __construct(
        private string $id,
        private string $description,
        private int    $category,
        private float  $price,
    )
    {
    }

    public static function fromProduct(
        Product $product
    ): ProductResponse
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
    public function category(): int
    {
        return $this->category;
    }

    public function price(): int
    {
        return $this->price;
    }
}
