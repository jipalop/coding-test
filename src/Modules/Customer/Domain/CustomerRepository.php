<?php
declare(strict_types=1);

namespace App\Modules\Customer\Domain;

use App\Modules\Shared\Domain\CustomerId;

interface CustomerRepository
{
    /** @throws CustomerNotExists */
    public function find(CustomerId $customerId): Customer;
}
