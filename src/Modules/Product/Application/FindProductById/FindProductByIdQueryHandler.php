<?php

namespace App\Modules\Product\Application\FindProductById;

use App\Modules\Product\Application\ProductResponse;
use App\Modules\Product\Application\ProductResponseConverter;
use App\Modules\Product\Domain\ProductNotExists;
use App\Modules\Shared\Domain\Bus\Query\QueryHandler;
use App\Modules\Shared\Domain\ProductId;

readonly class FindProductByIdQueryHandler implements QueryHandler
{
    public function __construct(private ProductByIdFinder $finder)
    {
    }

    /**
     * @throws ProductNotExists
     */
    public function __invoke(FindProductByIdQuery $query): ProductResponse
    {
        $product = ($this->finder)(productId: new ProductId($query->productId()));
        return (new ProductResponseConverter())($product);
    }
}
