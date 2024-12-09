<?php

namespace App\Modules\Order\Application\Discounts;

use App\Modules\Order\Domain\Order;
use App\Modules\Order\Domain\OrderTotal;

class OrderOverThousandDiscount extends OrderDiscount
{
    const DESCRIPTION = 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.';

    public function apply(Order $order): void
    {
        if ($order->total() > 1000) {
            $total = $order->total()->value();
            $total = ($total * 0.1);
            $order->setTotal(new OrderTotal($total));
            $order->appliedDiscounts()->addDiscount($this);
        }
    }
}
