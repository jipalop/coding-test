<?php

declare(strict_types=1);

namespace App\Modules\Order\Application;

use App\Modules\Order\Domain\Order;

class OrderResponseConverter
{
    public function __invoke(Order $order): OrderResponse
    {
        return $this->toResponse($order);
    }

    private function toResponse(Order $order): OrderResponse
    {
        return OrderResponse::fromOrder($order);
    }
}
