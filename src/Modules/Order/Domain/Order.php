<?php
declare(strict_types=1);

namespace App\Modules\Order\Domain;

use App\Modules\Shared\Domain\CustomerId;

class Order
{
    private function __construct(
        private readonly OrderId    $id,
        private readonly CustomerId $customerId,
        private readonly Items      $items,
        private OrderTotal $total,
        private AppliedDiscounts $appliedDiscounts,
    )
    {
    }

    public static function create(int $id, int $customerId, array $items, float $total): Order
    {
        return new self(
            new OrderId($id),
            new CustomerId($customerId),
            new Items($items),
            new OrderTotal($total),
            new AppliedDiscounts([])
        );
    }

    public static function fromJson(string $orderString): Order
    {
        $orderArray = json_decode($orderString, true);
        $items = [];
        foreach ($orderArray['items'] as $itemArray) {
            $item = Item::fromArray($itemArray);
            $items[] = $item;
        }
        return self::create((int)$orderArray['id'], (int)$orderArray['customer-id'], $items, (float)$orderArray['total']);
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function customerId(): CustomerId
    {
        return $this->customerId;
    }

    public function items(): Items
    {
        return $this->items;
    }

    public function total(): OrderTotal
    {
        return $this->total;
    }
    public function setTotal(OrderTotal $total):void
    {
        $this->total = $total;
    }

    public function appliedDiscounts(): AppliedDiscounts
    {
        return $this->appliedDiscounts;
    }
}
