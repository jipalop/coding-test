<?php

namespace App\Modules\Order\Domain;

interface DiscountsApplier
{
    public function applyDiscounts(Order $order): void;
}
