<?php
declare(strict_types=1);

namespace App\Modules\Order\Domain;

use App\Shared\Domain\CustomerId;
use App\Types\Exception\InvalidOrderFormat;

class Order
{
    private function __construct(
        private readonly OrderId    $id,
        private readonly CustomerId $customerId,
        private readonly Items      $items,
        private readonly OrderTotal $total,
    )
    {
    }

    public static function create(int $id, int $customerId, array $items, float $total): Order
    {
        return new self(
            new OrderId($id),
            new CustomerId($customerId),
            new Items($items),
            new OrderTotal($total)
        );
    }

    /**
     * @throws InvalidOrderFormat
     */
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
}