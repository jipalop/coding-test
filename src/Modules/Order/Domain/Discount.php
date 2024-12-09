<?php

namespace App\Modules\Order\Domain;

interface Discount
{

    public function apply(Order $order): void;
}
