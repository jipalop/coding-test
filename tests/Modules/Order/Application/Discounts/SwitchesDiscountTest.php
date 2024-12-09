<?php

namespace App\Tests\Modules\Order\Application\Discounts;

use App\Modules\Order\Application\Discounts\SwitchesDiscount;
use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Product\Domain\Product;
use App\Modules\Product\Domain\ProductRepository;
use App\Modules\Product\Infrastructure\Persistence\InMemoryProductRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SwitchesDiscountTest extends TestCase
{
    private MockObject|ProductRepository $productRepository;

    public function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepository::class);
    }

    public static function ItShouldApplyDiscountDataProvider(): array
    {
        return [
            [Order::create(id: 1, customerId: 1, items: [Item::create(2, 6, 200.00, 1200.00)], total: 1200.0), 1000, 200.00],
            [Order::create(id: 1, customerId: 1, items: [Item::create(2, 24, 100.00, 2400.00)], total: 2400.0), 2000, 100.00],
        ];
    }

    /**
     * @dataProvider ItShouldApplyDiscountDataProvider
     */
    public function testItShouldApplyDiscount(Order $order, float $expectedTotal, float $productPrice): void
    {
        $product = Product::create('A', 'switch', 2, $productPrice);
        $this->productRepository->expects($this->once())->method('find')->with($order->items()->get('0')->productId())->willReturn($product);
        $discount = new SwitchesDiscount($this->productRepository);
        $discount->apply($order);
        $this->assertEquals($expectedTotal, $order->total()->value());
        $this->assertIsArray($order->appliedDiscounts()->items());
        $this->assertNotEmpty($order->appliedDiscounts()->items());
        $this->assertCount(1, $order->appliedDiscounts()->items());
        $this->assertEquals(SwitchesDiscount::DESCRIPTION, $order->appliedDiscounts()->get('0')::DESCRIPTION);
    }

    public static function ItShouldNotApplyDiscountDataProvider()
    {
        return [
            [Order::create(id: 1, customerId: 1, items: [Item::create(3, 6, 200.00, 1200.00)], total: 1200.00), 1200.00, 200.00],
            [Order::create(id: 1, customerId: 1, items: [Item::create(1, 24, 100.00, 2400.00)], total: 2400.00), 2400.00, 100.00],
        ];
    }

    /**
     * @dataProvider ItShouldNotApplyDiscountDataProvider
     */
    public function testItShouldNotApplyDiscount(Order $order, float $expectedTotal, float $productPrice): void
    {
        $product = Product::create('B', 'other', 4, $productPrice);
        $this->productRepository->expects($this->once())->method('find')->with($order->items()->get('0')->productId())->willReturn($product);
        $discount = new SwitchesDiscount($this->productRepository);
        $discount->apply($order);
        $this->assertEmpty($order->appliedDiscounts()->items());
        $this->assertCount(0, $order->appliedDiscounts()->items());
    }
}
