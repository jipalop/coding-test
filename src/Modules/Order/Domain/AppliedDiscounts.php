<?php
declare(strict_types=1);

namespace App\Modules\Order\Domain;

use App\Types\ValueObject\ArrayValueObject;

class AppliedDiscounts extends ArrayValueObject
{
    public function addDiscount(Discount $discount): void
    {
        $this->items[] = $discount;
    }
}
