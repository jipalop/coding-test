<?php
declare(strict_types=1);

namespace App\Modules\Product\Domain;

class Product
{
    private function __construct(
        private ProductId          $productId,
        private ProductDescription $productDescription,
        private ProductCategory    $productCategory,
        private ProductPrice       $productPrice,
    )
    {
    }

    public static function create(string $productId, string $productDescription, int $productCategory, float $productPrice): Product
    {
        return new self(
            new ProductId($productId),
            new ProductDescription($productDescription),
            new ProductCategory($productCategory),
            new ProductPrice($productPrice)
        );
    }

    public function ProductId(): ProductId
    {
        return $this->productId;
    }

    public function setProductId(ProductId $productId): Product
    {
        $this->productId = $productId;
        return $this;
    }

    public function ProductDescription(): ProductDescription
    {
        return $this->productDescription;
    }

    public function setProductDescription(ProductDescription $productDescription): Product
    {
        $this->productDescription = $productDescription;
        return $this;
    }

    public function ProductCategory(): ProductCategory
    {
        return $this->productCategory;
    }

    public function setProductCategory(ProductCategory $productCategory): Product
    {
        $this->productCategory = $productCategory;
        return $this;
    }

    public function ProductPrice(): ProductPrice
    {
        return $this->productPrice;
    }

    public function setProductPrice(ProductPrice $productPrice): Product
    {
        $this->productPrice = $productPrice;
        return $this;
    }

}