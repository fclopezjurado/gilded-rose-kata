<?php

namespace App\Domain\Model;

final class Conjured extends Item
{
    private const NAME = 'Conjured';

    public function __construct(public int $sellIn, public int $quality)
    {
        parent::__construct(name: self::NAME, sellIn: $sellIn, quality: $quality);
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();
        $this->decreaseQuality();

        if ($this->hasSellInPassed()) {
            $this->decreaseQuality();
            $this->decreaseQuality();
        }
    }
}
