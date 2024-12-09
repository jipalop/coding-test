<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\FindProductById;

use App\Modules\Product\Domain\Product;
use App\Modules\Product\Domain\ProductNotExists;
use App\Modules\Product\Domain\ProductRepository;
use App\Modules\Shared\Domain\ProductId;

final readonly class ProductByIdFinder
{
    public function __construct(private ProductRepository $repository)
    {
    }

    /**
     * @throws ProductNotExists
     */
    public function __invoke(ProductId $productId): Product
    {
        return $this->repository->find($productId);
    }
}
