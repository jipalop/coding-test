<?php

namespace App\Tests\Modules\Order\Application\Discounts;

use App\Modules\Order\Application\Discounts\OrderOverThousandDiscount;
use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use PHPUnit\Framework\TestCase;

class OrderOverThousandDiscountTest extends TestCase
{
    public static function ItShouldApplyDiscountDataProvider(): array
    {
        return [
            [Order::create(id: 1, customerId: 1, items: [Item::create('A', 5, 250.50, 1252.50)], total: 1252.50), 1127.25],
            [Order::create(id: 1, customerId: 1, items: [Item::create('A', 5, 200.00, 1252.50)], total: 1000.01), 900.01]
        ];
    }

    /**
     * @dataProvider ItShouldApplyDiscountDataProvider
     */
    public function testItShouldApplyDiscount(Order $order, float $expectedTotal): void
    {
        $discount = new orderOverThousandDiscount();
        $discount->apply($order);
        $this->assertEquals($expectedTotal, $order->total()->value());
        $this->assertIsArray($order->appliedDiscounts()->items());
        $this->assertNotEmpty($order->appliedDiscounts()->items());
        $this->assertCount(1, $order->appliedDiscounts()->items());
        $this->assertEquals(OrderOverThousandDiscount::DESCRIPTION, $order->appliedDiscounts()->get('0')::DESCRIPTION);
    }

    public static function ItShouldNotApplyDiscountDataProvider(): array
    {
        return [
            [Order::create(id: 1, customerId: 1, items: [Item::create('A', 5, 100.00, 500.00)], total: 500.00), 500.00],
            [Order::create(id: 1, customerId: 1, items: [Item::create('A', 1, 999.99, 999.99)], total: 999.99), 999.99],
        ];
    }

    /**
     * @dataProvider ItShouldNotApplyDiscountDataProvider
     */
    public function testItShouldNotApplyDiscount(Order $order, float $expectedTotal): void
    {
        $discount = new orderOverThousandDiscount();
        $discount->apply($order);
        $this->assertEquals($expectedTotal, $order->total()->value());
        $this->assertEmpty($order->appliedDiscounts()->items());
        $this->assertCount(0, $order->appliedDiscounts()->items());
    }
}
