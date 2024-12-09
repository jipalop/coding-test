<?php

declare(strict_types=1);

namespace App\Modules\Customer\Infrastructure\Persistence;

use App\Modules\Customer\Domain\Customer;
use App\Modules\Customer\Domain\CustomerNotExists;
use App\Modules\Customer\Domain\CustomerRepository;
use App\Modules\Shared\Domain\CustomerId;
use App\Types\Exception\InvalidDateTime;

class InMemoryCustomerRepository implements CustomerRepository
{
    private const CUSTOMERS = [
        1 => [
            'id' => 1,
            'name' => 'Coca Cola',
            'since' => '2014-06-28',
            'revenue' => 492.12
        ],
        2 => [
            'id' => 2,
            'name' => 'Teamleader',
            'since' => '2015-01-15',
            'revenue' => 1505.95
        ],
        3 => [
            'id' => 3,
            'name' => 'Jeroen De Wit',
            'since' => '2016-02-11',
            'revenue' => 0.00
        ],
    ];


    /**
     * @throws CustomerNotExists
     * @throws InvalidDateTime
     */
    public function find(CustomerId $customerId): Customer
    {
        if (!isset(self::CUSTOMERS[$customerId->value()])) {

            throw CustomerNotExists::withId($customerId);
        }
        $customerData = self::CUSTOMERS[$customerId->value()];
        return Customer::create(
            $customerId->value(),
            $customerData['name'],
            $customerData['since'],
            $customerData['revenue']
        );
    }

}
