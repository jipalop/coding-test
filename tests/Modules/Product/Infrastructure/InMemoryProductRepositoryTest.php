<?php

namespace App\Tests\Modules\Product\Infrastructure;

use App\Modules\Product\Domain\Product;
use App\Modules\Product\Domain\ProductNotExists;
use App\Modules\Product\Infrastructure\Persistence\InMemoryProductRepository;
use App\Modules\Shared\Domain\ProductId;
use PHPUnit\Framework\TestCase;

class InMemoryProductRepositoryTest extends TestCase
{
    public static function findProductDataProvider()
    {
        return [
            ['A101', Product::create('A101', 'Screwdriver', 1, 9.75)],
            ['A102', Product::create('A102', 'Electric screwdriver', 1, 49.50)],
            ['B101', Product::create('B101', 'Basic on-off switch', 2, 4.99)],
            ['B102', Product::create('B102', 'Press button', 2, 4.99)],
            ['B103', Product::create('B103', 'Switch with motion detector', 2, 12.95)],
        ];
    }

    /**
     * @dataProvider findProductDataProvider
     */
    public function testItShouldFindAndReturnCustomer(string $id, Product $expectedProduct): void
    {
        $repo = new InMemoryProductRepository();
        $product = $repo->find(new ProductId($id));

        $this->assertEquals($product->id(), $expectedProduct->id());
        $this->assertEquals($product->description(), $expectedProduct->description());
        $this->assertEquals($product->category(), $expectedProduct->category());
        $this->assertEquals($product->price(), $expectedProduct->price());
    }

    public function testItShouldNotFindAndThrowException(): void
    {
        $this->expectException(ProductNotExists::class);
        $repo = new InMemoryProductRepository();
        $repo->find(new ProductId(0));
    }
}
