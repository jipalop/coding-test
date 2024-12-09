<?php

namespace App\Modules\Order\Application\Discounts;
use App\Modules\Order\Domain\Discount;
use App\Modules\Order\Domain\Order;

abstract class OrderDiscount implements Discount
{
    const DESCRIPTION = 'Discount';

    public function apply(Order $order): void
    {
    }
}
