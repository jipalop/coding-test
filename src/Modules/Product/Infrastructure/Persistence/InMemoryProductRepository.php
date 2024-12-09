<?php

declare(strict_types=1);

namespace App\Modules\Product\Infrastructure\Persistence;

use App\Modules\Product\Domain\Product;
use App\Modules\Product\Domain\ProductNotExists;
use App\Modules\Product\Domain\ProductRepository;
use App\Modules\Shared\Domain\ProductId;

class InMemoryProductRepository implements ProductRepository
{
    private const array PRODUCTS = [
        'A101' => [
            'id' => 'A101',
            'description' => 'Screwdriver',
            'category' => 1,
            'price' => 9.75
        ],
        'A102' => [
            'id' => 'A102',
            'description' => 'Electric screwdriver',
            'category' => 1,
            'price' => 49.50
        ],
        'B101' => [
            'id' => 'B101',
            'description' => 'Basic on-off switch',
            'category' => 2,
            'price' => 4.99
        ],
        'B102' => [
            'id' => 'B102',
            'description' => 'Press button',
            'category' => 2,
            'price' => 4.99
        ],
        'B103' => [
            'id' => 'B103',
            'description' => 'Switch with motion detector',
            'category' => 2,
            'price' => 12.95
        ],
    ];

    /**
     * @throws ProductNotExists
     */
    public function find(ProductId $productId): Product
    {
        if (!isset(self::PRODUCTS[$productId->value()])) {

            throw ProductNotExists::withId($productId);
        }
        $productData = self::PRODUCTS[$productId->value()];
        return Product::create(
            $productId->value(),
            $productData['description'],
            $productData['category'],
            $productData['price']
        );
    }

}
