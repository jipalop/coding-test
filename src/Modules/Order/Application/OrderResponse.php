<?php

namespace App\Modules\Order\Application;

use App\Modules\Order\Application\Discounts\OrderDiscount;
use App\Modules\Order\Domain\Order;
use App\Modules\Shared\Domain\Bus\Query\Response;

readonly class OrderResponse implements Response
{
    public function __construct(
        private int    $id,
        private string $customerId,
        private array  $items,
        private float  $total,
        private array  $appliedDiscounts,
    )
    {
    }

    public static function fromOrder(
        Order $order
    ): OrderResponse
    {
        $items = [];
        foreach ($order->items()->items() as $item) {
            $items[] = ItemResponse::fromItem($item)->toPlain();
        }

        $discounts = [];
        /** @var OrderDiscount $discount */
        foreach ($order->appliedDiscounts()->items() as $discount) {
            $discounts[] = $discount::DESCRIPTION;
        }

        return new self(
            $order->id()->value(),
            $order->customerId()->value(),
            $items,
            $order->total()->value(),
            $discounts
        );
    }

    public function toPlain(): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customerId,
            'items' => $this->items,
            'total' => $this->total,
            'applied_discounts' => $this->appliedDiscounts,
        ];
    }
}
