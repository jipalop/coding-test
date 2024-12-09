<?php

namespace App\Modules\Order\Application\Discounts;

use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Order\Domain\OrderTotal;
use App\Modules\Product\Application\FindProductById\FindProductByIdQuery;
use App\Modules\Product\Domain\ProductNotExists;
use App\Modules\Shared\Domain\Bus\Query\QueryBus;

class SwitchesDiscount extends OrderDiscount
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public const string DESCRIPTION = 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.';
    private const int SWITCHES_CATEGORY = 2;

    /**
     * @throws ProductNotExists
     */
    public function apply(Order $order): void
    {
        /** @var Item $item */
        foreach ($order->items()->items() as $item) {
            $productResponse = $this->queryBus->ask(new FindProductByIdQuery($item->productId()));
            if ($productResponse->category() == self::SWITCHES_CATEGORY) {
                $discountItems = (int)($item->quantity()->value() / 6);
                $total = $order->total()->value();
                $total = ($total - ($discountItems * $item->unitPrice()->value()));
                $order->setTotal(new OrderTotal(round($total, 2, PHP_ROUND_HALF_DOWN)));
                $order->appliedDiscounts()->addDiscount($this);
            }
        }
    }
}
