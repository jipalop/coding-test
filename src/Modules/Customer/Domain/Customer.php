<?php
declare(strict_types=1);

namespace App\Modules\Customer\Domain;

use App\Modules\Shared\Domain\CustomerId;
use App\Types\Exception\InvalidDateTime;

class Customer
{
    private function __construct(
        private readonly CustomerId      $id,
        private readonly CustomerName    $name,
        private readonly CustomerSince   $since,
        private readonly CustomerRevenue $revenue,
    )
    {
    }

    /**
     * @throws InvalidDateTime
     */
    public static function create(int $id, string $name, string $since, float $revenue): Customer
    {
        return new self(
            new CustomerId($id),
            new CustomerName($name),
            CustomerSince::fromString($since),
            new CustomerRevenue($revenue)
        );
    }

    public function id(): CustomerId
    {
        return $this->id;
    }


    public function name(): CustomerName
    {
        return $this->name;
    }

    public function since(): CustomerSince
    {
        return $this->since;
    }

    public function revenue(): CustomerRevenue
    {
        return $this->revenue;
    }

}
