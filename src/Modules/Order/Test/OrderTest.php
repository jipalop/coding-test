<?php
declare(strict_types=1);

namespace App\Modules\Order\Test;

use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testItShouldCreateAnOrderFromJsonString(): void
    {
        $validOrder = '{
                          "id": "1",
                          "customer-id": "1",
                          "items": [
                            {
                              "product-id": "B102",
                              "quantity": "10",
                              "unit-price": "4.99",
                              "total": "49.90"
                            }
                          ],
                          "total": "49.90"
                        }';

        $order = Order::fromJson($validOrder);

        $this->assertEquals(1, $order->id()->value());
        $this->assertEquals(1, $order->customerId()->value());
        $this->assertEquals(49.90, $order->total()->value());
        $items = $order->items();
        $this->assertIsArray($items->items());
        /** @var Item $item */
        $item = $items->get('0');
        $this->assertEquals("B102", $item->productId()->value());
        $this->assertEquals(10, $item->quantity()->value());
        $this->assertEquals(4.99, $item->unitPrice()->value());
        $this->assertEquals(49.90, $item->total()->value());
    }
}
