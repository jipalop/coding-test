<?php

namespace App\Modules\Order\Application;

use App\Modules\Order\Domain\Item;
use App\Modules\Shared\Domain\Bus\Query\Response;

readonly class ItemResponse implements Response
{
    public function __construct(
        private string $productId,
        private int    $quantity,
        private float  $unitPrice,
        private float  $total,
    )
    {
    }

    public static function fromItem(
        Item $item
    ): ItemResponse
    {
        return new self(
            $item->productId()->value(),
            $item->quantity()->value(),
            $item->unitPrice()->value(),
            $item->total()->value()
        );
    }

    public function toPlain(): array
    {
        return [
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
            'unit_price' => $this->unitPrice,
            'total' => $this->total,
        ];
    }
}
