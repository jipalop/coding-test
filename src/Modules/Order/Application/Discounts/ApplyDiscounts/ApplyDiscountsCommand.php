<?php
declare(strict_types=1);
namespace App\Modules\Order\Application\Discounts\ApplyDiscounts;

use App\Modules\Order\Domain\Order;
use App\Modules\Shared\Domain\Bus\Command\Command;

readonly class ApplyDiscountsCommand implements Command
{
    public function __construct(private Order $order)
    {
    }

    public function order(): Order
    {
        return $this->order;
    }

}
