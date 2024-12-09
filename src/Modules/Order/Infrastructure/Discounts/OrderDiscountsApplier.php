<?php
declare(strict_types=1);
namespace App\Modules\Order\Infrastructure\Discounts;

use App\Modules\Order\Domain\Discount;
use App\Modules\Order\Domain\DiscountsApplier;
use App\Modules\Order\Domain\Order;

readonly class OrderDiscountsApplier implements DiscountsApplier
{

    public function __construct(private array $discounts)
    {
    }

    public function __invoke(Order $order): void
    {
        /** @var Discount $discount */
        foreach ($this->discounts as $discount) {
            $discount->apply($order);
        }
    }
}
