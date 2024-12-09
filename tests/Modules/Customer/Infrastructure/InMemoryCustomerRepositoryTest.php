<?php

namespace App\Tests\Modules\Customer\Infrastructure;

use App\Modules\Customer\Domain\Customer;
use App\Modules\Customer\Domain\CustomerNotExists;
use App\Modules\Customer\Infrastructure\Persistence\InMemoryCustomerRepository;
use App\Modules\Shared\Domain\CustomerId;
use PHPUnit\Framework\TestCase;

class InMemoryCustomerRepositoryTest extends TestCase
{
    public static function findCustomerDataProvider()
    {
        return [
            [1, Customer::create(1, 'Coca Cola', '2014-06-28', 492.12)],
            [2, Customer::create(2, 'Teamleader', '2015-01-15', 1505.95)],
            [3, Customer::create(3, 'Jeroen De Wit', '2016-02-11', 0.00)],
        ];
    }

    /**
     * @dataProvider findCustomerDataProvider
     */
    public function testItShouldFindAndReturnCustomer(int $id, Customer $expectedCustomer): void
    {
        $repo = new InMemoryCustomerRepository();
        $customer = $repo->find(new CustomerId($id));

        $this->assertEquals($customer->id(), $expectedCustomer->id());
        $this->assertEquals($customer->name(), $expectedCustomer->name());
        $this->assertEquals($customer->since(), $expectedCustomer->since());
        $this->assertEquals($customer->revenue(), $expectedCustomer->revenue());
    }

    public function testItShouldNotFindAndThrowException(): void
    {
        $this->expectException(CustomerNotExists::class);
        $repo = new InMemoryCustomerRepository();
        $repo->find(new CustomerId(0));
    }
}
