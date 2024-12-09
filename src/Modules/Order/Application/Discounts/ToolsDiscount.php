<?php

namespace App\Modules\Order\Application\Discounts;

use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Order\Domain\OrderTotal;
use App\Modules\Product\Domain\ProductRepository;

class ToolsDiscount extends OrderDiscount
{
    const DESCRIPTION = 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.';

    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function apply(Order $order): void
    {
        $tools = 0;
        $cheapestToolPrice = null;
        /** @var Item $item */
        foreach ($order->items()->items() as $item) {
            $product = $this->productRepository->find($item->productId());
            if ($product->category()->value() == 2) {
                $tools++;
                if ($cheapestToolPrice == null || $cheapestToolPrice > $product->price()->value()) {
                    $cheapestToolPrice = $product->price();
                }
            }
        }

        if ($cheapestToolPrice != null) {
            $total = $order->total()->value();
            $total = ($total - ($cheapestToolPrice->value() * 0.2));
            $order->setTotal(new OrderTotal($total));
            $order->appliedDiscounts()->addDiscount($this);
        }
    }
}
