<?php
declare(strict_types=1);

namespace App\Modules\Order\Domain;

use App\Modules\Shared\Domain\ProductId;
use App\Modules\Shared\Domain\ProductPrice;

class AppliedDiscount
{
    private function __construct(
        private readonly ProductId    $productId,
        private readonly ItemQuantity $quantity,
        private readonly ProductPrice $unitPrice,
        private readonly ItemsTotal   $total,
    )
    {
    }

    public static function create(string $productId, int $quantity, float $unitPrice, float $total): Discount
    {
        return new self(
            new ProductId($productId),
            new ItemQuantity($quantity),
            new ProductPrice($unitPrice),
            new ItemsTotal($total)
        );
    }

    public static function fromArray(array $items): Discount
    {
        return self::create($items['product-id'], (int)$items['quantity'], (float)$items['unit-price'], (float)$items['total']);
    }

    public function productId(): ProductId
    {
        return $this->productId;
    }

    public function quantity(): ItemQuantity
    {
        return $this->quantity;
    }

    public function unitPrice(): ProductPrice
    {
        return $this->unitPrice;
    }

    public function total(): ItemsTotal
    {
        return $this->total;
    }

}