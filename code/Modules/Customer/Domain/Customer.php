<?php
declare(strict_types=1);

namespace App\Modules\Customer\Domain;

use DateTimeImmutable;

class Customer
{
    private function __construct(
        private CustomerId      $customerId,
        private CustomerName    $customerName,
        private CustomerSince   $customerSince,
        private CustomerRevenue $customerRevenue,
    )
    {
    }

    public static function create(int $customerId, string $customerName, DateTimeImmutable $customerSince, float $customerRevenue): Customer
    {
        return new self(
            new CustomerId($customerId),
            new CustomerName($customerName),
            new CustomerSince($customerSince),
            new CustomerRevenue($customerRevenue)
        );
    }

    public function Id(): CustomerId
    {
        return $this->customerId;
    }

    public function setCustomerId(CustomerId $customerId): Customer
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function CustomerName(): CustomerName
    {
        return $this->customerName;
    }

    public function setCustomerName(CustomerName $customerName): Customer
    {
        $this->customerName = $customerName;
        return $this;
    }

    public function CustomerSince(): CustomerSince
    {
        return $this->customerSince;
    }

    public function setCustomerSince(CustomerSince $customerSince): Customer
    {
        $this->customerSince = $customerSince;
        return $this;
    }

    public function CustomerRevenue(): CustomerRevenue
    {
        return $this->customerRevenue;
    }

    public function setCustomerRevenue(CustomerRevenue $customerRevenue): Customer
    {
        $this->customerRevenue = $customerRevenue;
        return $this;
    }

}