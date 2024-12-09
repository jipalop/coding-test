<?php

namespace App\Tests\Modules\Order\Application\Discounts;

use App\Modules\Order\Application\Discounts\ToolsDiscount;
use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Product\Application\FindProductById\FindProductByIdQuery;
use App\Modules\Product\Application\ProductResponseConverter;
use App\Modules\Product\Domain\Product;
use App\Modules\Shared\Domain\Bus\Query\QueryBus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ToolsDiscountTest extends TestCase
{
    private MockObject|QueryBus $queryBus;

    public function setUp(): void
    {
        $this->queryBus = $this->createMock(QueryBus::class);
    }

    public function testItShouldApplyDiscount(): void
    {
        $tool1 = Product::create('A', 'toolA', 1, 100.00);
        $tool2 = Product::create('B', 'toolB', 1, 200.00);
        $product3 = Product::create('C', 'productC', 4, 500.00);

        $tool1Response = (new ProductResponseConverter)($tool1);
        $tool2Response = (new ProductResponseConverter)($tool2);
        $product3Response = (new ProductResponseConverter)($product3);

        $this->queryBus->expects($this->exactly(3))->method('ask')->willReturnCallback(function (FindProductByIdQuery $query) use ($tool1Response, $tool2Response, $product3Response) {
            return match ($query->productId()) {
                'A' => $tool1Response,
                'B' => $tool2Response,
                'C' => $product3Response
            };
        });

        $order = Order::create(
            id: 1,
            customerId: 1,
            items: [
                Item::create(productId: $tool1->id()->value(), quantity: 1, unitPrice: $tool1->price()->value(), total: 100.00),
                Item::create(productId: $tool2->id()->value(), quantity: 1, unitPrice: $tool2->price()->value(), total: 200.00),
                Item::create(productId: $product3->id()->value(), quantity: 2, unitPrice: $product3->price()->value(), total: 1000.00)
            ],
            total: 1300.00
        );

        $expectedTotal = 1280.00;

        $discount = new ToolsDiscount($this->queryBus);
        $discount->apply($order);
        $this->assertEquals($expectedTotal, $order->total()->value());
        $this->assertIsArray($order->appliedDiscounts()->items());
        $this->assertNotEmpty($order->appliedDiscounts()->items());
        $this->assertCount(1, $order->appliedDiscounts()->items());
        $this->assertEquals(ToolsDiscount::DESCRIPTION, $order->appliedDiscounts()->get('0')::DESCRIPTION);
    }

    public function testItShouldNotApplyDiscount(): void
    {
        $tool1 = Product::create('C', 'toolC', 1, 100.00);
        $product2 = Product::create('D', 'productC', 2, 200.00);
        $product3 = Product::create('F', 'productF', 4, 500.00);

        $tool1Response = (new ProductResponseConverter)($tool1);
        $product2Response = (new ProductResponseConverter)($product2);
        $product3Response = (new ProductResponseConverter)($product3);

        $this->queryBus->expects($this->exactly(3))->method('ask')->willReturnCallback(function (FindProductByIdQuery $query) use ($tool1Response, $product2Response, $product3Response) {
            return match ($query->productId()) {
                'C' => $tool1Response,
                'D' => $product2Response,
                'F' => $product3Response
            };
        });

        $order = Order::create(
            id: 1,
            customerId: 1,
            items: [
                Item::create(productId: $tool1->id()->value(), quantity: 1, unitPrice: $tool1->price()->value(), total: 100.00),
                Item::create(productId: $product2->id()->value(), quantity: 1, unitPrice: $product2->price()->value(), total: 200.00),
                Item::create(productId: $product3->id()->value(), quantity: 2, unitPrice: $product3->price()->value(), total: 1000.00)
            ],
            total: 1300.00
        );

        $expectedTotal = 1300.00;

        $discount = new ToolsDiscount($this->queryBus);
        $discount->apply($order);
        $this->assertEquals($expectedTotal, $order->total()->value());
        $this->assertEmpty($order->appliedDiscounts()->items());
        $this->assertCount(0, $order->appliedDiscounts()->items());
    }
}
