<?php

namespace App\Modules\Product\Application\FindProductById;

use App\Modules\Product\Application\OrderResponse;
use App\Modules\Product\Application\OrderResponseConverter;
use App\Modules\Shared\Domain\Bus\Query\QueryHandler;
use App\Modules\Shared\Domain\ProductId;

class FindProductByIdQueryHandler implements QueryHandler
{
    public function __construct(private readonly ProductByIdFinder $finder)
    {
    }

    public function __invoke(FindProductByIdQuery $query): OrderResponse
    {
        $product = ($this->finder)(productId: new ProductId($query->productId()));
        return (new OrderResponseConverter())($product);
    }
}
