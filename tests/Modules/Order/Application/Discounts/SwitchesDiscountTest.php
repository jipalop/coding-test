<?php

namespace App\Tests\Modules\Order\Application\Discounts;

use App\Modules\Order\Application\Discounts\SwitchesDiscount;
use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Product\Application\FindProductById\FindProductByIdQuery;
use App\Modules\Product\Application\ProductResponseConverter;
use App\Modules\Product\Domain\Product;
use App\Modules\Shared\Domain\Bus\Command\Command;
use App\Modules\Shared\Domain\Bus\Query\QueryBus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SwitchesDiscountTest extends TestCase
{
    private MockObject|QueryBus $queryBus;

    public function setUp(): void
    {
        $this->queryBus = $this->createMock(QueryBus::class);
    }

    public static function ItShouldApplyDiscountDataProvider(): array
    {
        return [
            [Order::create(id: 1, customerId: 1, items: [Item::create('A', 6, 200.00, 1200.00)], total: 1200.0), 1000, 200.00],
            [Order::create(id: 1, customerId: 1, items: [Item::create('B', 24, 100.00, 2400.00)], total: 2400.0), 2000, 100.00],
        ];
    }

    /**
     * @dataProvider ItShouldApplyDiscountDataProvider
     */
    public function testItShouldApplyDiscount(Order $order, float $expectedTotal, float $productPrice): void
    {
        $item = $order->items()->get('0');
        $product = Product::create($item->productId()->value(), 'switch', 2, $productPrice);
        $productResponse = (new ProductResponseConverter)($product);

        $this->queryBus->expects($this->once())->method('ask')->with((new FindProductByIdQuery($product->id())))->willReturn($productResponse);

        $discount = new SwitchesDiscount($this->queryBus);
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
            [Order::create(id: 1, customerId: 1, items: [Item::create('B', 6, 200.00, 1200.00)], total: 1200.00), 1200.00, 200.00],
            [Order::create(id: 1, customerId: 1, items: [Item::create('C', 24, 100.00, 2400.00)], total: 2400.00), 2400.00, 100.00],
        ];
    }

    /**
     * @dataProvider ItShouldNotApplyDiscountDataProvider
     */
    public function testItShouldNotApplyDiscount(Order $order, float $expectedTotal, float $productPrice): void
    {
        $item = $order->items()->get('0');
        $product = Product::create($item->productId()->value(), 'other', 4, $productPrice);
        $productResponse = (new ProductResponseConverter)($product);

        $this->queryBus->expects($this->once())->method('ask')->with((new FindProductByIdQuery($product->id())))->willReturn($productResponse);
        $discount = new SwitchesDiscount($this->queryBus);
        $discount->apply($order);
        $this->assertEmpty($order->appliedDiscounts()->items());
        $this->assertCount(0, $order->appliedDiscounts()->items());
    }

    protected function dispatch(Command $command, callable $handler): void
    {
        $handler($command);
    }
}
