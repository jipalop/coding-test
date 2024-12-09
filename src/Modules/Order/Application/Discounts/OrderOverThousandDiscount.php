<?php

namespace App\Modules\Order\Application\Discounts;

use App\Modules\Order\Domain\Order;
use App\Modules\Order\Domain\OrderTotal;

class OrderOverThousandDiscount extends OrderDiscount
{
    const string DESCRIPTION = 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.';

    public function apply(Order $order): void
    {
        if ($order->total()->value() > 1000) {
            $total = $order->total()->value();
            $total = $total - ($total * 0.1);
            $order->setTotal(new OrderTotal(round($total, 2, PHP_ROUND_HALF_DOWN)));
            $order->appliedDiscounts()->addDiscount($this);
        }
    }
}
