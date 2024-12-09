<?php
declare(strict_types=1);

namespace App\Modules\Product\Domain;

use App\Modules\Shared\Domain\ProductId;
use App\Modules\Shared\Domain\ProductPrice;

class Product
{
    private function __construct(
        private readonly ProductId          $id,
        private readonly ProductDescription $description,
        private readonly ProductCategory    $category,
        private readonly ProductPrice       $price,
    )
    {
    }

    public static function create(string $id, string $description, int $category, float $price): Product
    {
        return new self(
            new ProductId($id),
            new ProductDescription($description),
            new ProductCategory($category),
            new ProductPrice($price)
        );
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function description(): ProductDescription
    {
        return $this->description;
    }

    public function category(): ProductCategory
    {
        return $this->category;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

}
