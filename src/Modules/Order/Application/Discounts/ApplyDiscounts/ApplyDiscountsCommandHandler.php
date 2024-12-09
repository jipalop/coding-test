<?php
declare(strict_types=1);
namespace App\Modules\Order\Application\Discounts\ApplyDiscounts;

use App\Modules\Order\Domain\DiscountsApplier;

readonly class ApplyDiscountsCommandHandler
{
    public function __construct(private DiscountsApplier $discountsApplier)
    {
    }

    public function __invoke(ApplyDiscountsCommand $command): void
    {
        ($this->discountsApplier)($command->order());
    }
}
