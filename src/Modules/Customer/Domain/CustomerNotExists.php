<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain;

use App\Exceptions\DomainException;
use App\Modules\Shared\Domain\CustomerId;

final class CustomerNotExists extends DomainException
{
    private const MESSAGE = 'Customer does not exist';

    public static function withId(CustomerId $customerId): self
    {
        return new self(self::MESSAGE, 0, null, ['id' => $customerId->value()]);
    }

}
