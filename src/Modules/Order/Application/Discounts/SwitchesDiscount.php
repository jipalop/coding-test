<?php

namespace App\Modules\Order\Application\Discounts;

use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Order\Domain\OrderTotal;
use App\Modules\Product\Domain\ProductRepository;

class SwitchesDiscount extends OrderDiscount
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public const string DESCRIPTION = 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.';
    private const int SWITCHES_CATEGORY = 2;


    public function apply(Order $order): void
    {
        /** @var Item $item */
        foreach ($order->items()->items() as $item) {
            $product = $this->productRepository->find($item->productId());
            if ($product->category()->value() == self::SWITCHES_CATEGORY) {
                $discountItems = (int)($item->quantity()->value() / 6);
                $total = $order->total()->value();
                $total = ($total - ($discountItems * $item->unitPrice()->value()));
                $order->setTotal(new OrderTotal($total));
                $order->appliedDiscounts()->addDiscount($this);
            }
        }
    }
}
