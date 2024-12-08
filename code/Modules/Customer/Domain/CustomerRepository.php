<?php
declare(strict_types=1);

namespace App\Modules\Customer\Domain;

interface CustomerRepository
{
    /** @throws CustomerNotExists */
    public function find(CustomerId $customerId): Customer;
}