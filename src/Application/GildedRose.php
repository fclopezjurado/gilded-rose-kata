<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Model\Item;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function update(): void
    {
        foreach ($this->items as $item) {
            $item->update();
        }
    }
}
