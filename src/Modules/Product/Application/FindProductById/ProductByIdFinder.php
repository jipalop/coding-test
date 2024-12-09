<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\FindProductById;

use App\Modules\Product\Domain\Product;
use App\Modules\Product\Domain\ProductRepository;
use App\Modules\Shared\Domain\ProductId;

final class ProductByIdFinder
{
    public function __construct(private readonly ProductRepository $repository)
    {
    }

    public function __invoke(ProductId $productId): Product
    {
        return $this->repository->find($productId);
    }
}
