<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class Standard extends Item
{
    private const NAME = 'Standard';

    public function __construct(int $sellIn, int $quality)
    {
        parent::__construct(name: self::NAME, sellIn: $sellIn, quality: $quality);
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();

        if ($this->hasSellInPassed()) {
            $this->decreaseQuality();
        }
    }
}
