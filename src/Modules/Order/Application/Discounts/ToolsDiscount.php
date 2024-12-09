<?php

namespace App\Modules\Order\Application\Discounts;

use App\Modules\Order\Domain\Item;
use App\Modules\Order\Domain\Order;
use App\Modules\Order\Domain\OrderTotal;
use App\Modules\Product\Application\FindProductById\FindProductByIdQuery;
use App\Modules\Product\Domain\ProductNotExists;
use App\Modules\Product\Domain\ProductRepository;
use App\Modules\Shared\Domain\Bus\Query\QueryBus;

class ToolsDiscount extends OrderDiscount
{
    public const string DESCRIPTION = 'If you buy two or more products of category Tools (id 1), you get a 20% discount on the cheapest product.';
    private const int TOOLS_CATEGORY = 1;

    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    /**
     * @throws ProductNotExists
     */
    public function apply(Order $order): void
    {
        $tools = 0;
        $cheapestToolPrice = null;
        /** @var Item $item */
        foreach ($order->items()->items() as $item) {
            $productResponse = $this->queryBus->ask(new FindProductByIdQuery($item->productId()));
            if ($productResponse->category() == self::TOOLS_CATEGORY) {
                $tools++;
                if ($cheapestToolPrice == null || $cheapestToolPrice > $productResponse->price()) {
                    $cheapestToolPrice = $productResponse->price();
                }
            }
        }

        if ($cheapestToolPrice != null && $tools >= 2) {
            $total = $order->total()->value();
            $total = ($total - ($cheapestToolPrice * 0.2));
            $order->setTotal(new OrderTotal(round($total, 2, PHP_ROUND_HALF_DOWN)));
            $order->appliedDiscounts()->addDiscount($this);
        }
    }
}
