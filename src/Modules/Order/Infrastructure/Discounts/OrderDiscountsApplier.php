<?php

namespace App\Modules\Order\Infrastructure\Discounts;

use App\Modules\Order\Domain\Discount;
use App\Modules\Order\Domain\DiscountsApplier;
use App\Modules\Order\Domain\Order;

class OrderDiscountsApplier implements DiscountsApplier
{

    public function __construct(private readonly array $discounts)
    {
    }

    public function applyDiscounts(Order $order): void
    {
        /** @var Discount $discount */
        foreach ($this->discounts as $discount) {
            $discount->apply($order);
        }
    }
}
