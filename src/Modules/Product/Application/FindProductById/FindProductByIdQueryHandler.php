<?php

namespace App\Modules\Product\Application\FindProductById;

use App\Modules\Product\Application\ProductResponse;
use App\Modules\Product\Application\ProductResponseConverter;
use App\Modules\Shared\Domain\Bus\Query\QueryHandler;
use App\Modules\Shared\Domain\ProductId;

class FindProductByIdQueryHandler implements QueryHandler
{
    public function __construct(private readonly ProductByIdFinder $finder)
    {
    }

    public function __invoke(FindProductByIdQuery $query): ProductResponse
    {
        $product = ($this->finder)(productId: new ProductId($query->productId()));
        return (new ProductResponseConverter())($product);
    }
}
