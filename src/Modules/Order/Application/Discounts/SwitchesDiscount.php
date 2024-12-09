<?php
namespace App\Modules\Order\Application\Discounts;

use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Order\Domain\OrderTotal;

class SwitchesDiscount extends OrderDiscount
{
    const DESCRIPTION = 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.';
    public function apply(Order $order): void
    {
        $switches = 0;
        /** @var Item $item */
        foreach ($order->items()->items() as $item)
        {
            if ($item->productId()->value() == 2) {
                $switches++;
            }
            if ($switches == 6) {
                $switches = 0;
                $total = $order->total()->value();
                $total = ($total - $item->unitPrice()->value());
                $order->setTotal(new OrderTotal($total));
                $order->appliedDiscounts()->addDiscount($this);
            }
        }
    }
}
