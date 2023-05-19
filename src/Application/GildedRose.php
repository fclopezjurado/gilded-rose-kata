<?php

namespace App\Application;

use App\Domain\Item;

final readonly class GildedRose
{
    /**
     * @param array<Item> $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->update();
        }
    }
}
