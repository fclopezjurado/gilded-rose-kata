<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Item;

final readonly class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    public function update(): void
    {
        foreach ($this->items as $item) {
            $item->update();
        }
    }

    /**
     * @return Item[]
     */
    public function items(): array
    {
        return $this->items;
    }
}
