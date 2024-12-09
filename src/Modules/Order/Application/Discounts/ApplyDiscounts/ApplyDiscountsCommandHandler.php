<?php
declare(strict_types=1);
namespace App\Modules\Order\Application\Discounts\ApplyDiscounts;

use App\Modules\Order\Domain\DiscountsApplier;
use App\Modules\Shared\Domain\Bus\Command\CommandHandler;

readonly class ApplyDiscountsCommandHandler implements CommandHandler
{
    public function __construct(private DiscountsApplier $discountsApplier)
    {
    }

    public function __invoke(ApplyDiscountsCommand $command): void
    {
        ($this->discountsApplier)($command->order());
    }
}
