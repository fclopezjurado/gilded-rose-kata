<?php

declare(strict_types=1);

namespace App\Domain;

final class AgedBrie extends Item
{
    /**
     * @var int
     */
    private const DOUBLE_QUALITY_INCREASE_SELL_IN_THRESHOLD = 0;
    /**
     * @var string
     */
    private const NAME = 'Aged Brie';

    public function __construct(SellIn $sellIn, Quality $quality)
    {
        parent::__construct(new Name(self::NAME), $sellIn, $quality);
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->increaseQuality();

        if ($this->hasToBeSoldInLessThan(self::DOUBLE_QUALITY_INCREASE_SELL_IN_THRESHOLD)) {
            $this->increaseQuality();
        }
    }
}
