<?php

declare(strict_types=1);

namespace App\Domain;

final class BackstagePasses extends Item
{
    /**
     * @var int
     */
    private const DOUBLE_QUALITY_INCREASE_SELL_IN_THRESHOLD = 10;
    /**
     * @var int
     */
    private const TRIPLE_QUALITY_INCREASE_SELL_IN_THRESHOLD = 5;
    /**
     * @var int
     */
    private const RESET_QUALITY_SELL_IN_THRESHOLD = 0;
    /**
     * @var string
     */
    private const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function __construct(SellIn $sellIn, Quality $quality)
    {
        parent::__construct(new Name(self::NAME), $sellIn, $quality);
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();

        if ($this->hasToBeSoldInLessThan(self::DOUBLE_QUALITY_INCREASE_SELL_IN_THRESHOLD)) {
            $this->increaseQuality();
        }

        if ($this->hasToBeSoldInLessThan(self::TRIPLE_QUALITY_INCREASE_SELL_IN_THRESHOLD)) {
            $this->increaseQuality();
        }

        if ($this->hasToBeSoldInLessThan(self::RESET_QUALITY_SELL_IN_THRESHOLD)) {
            $this->resetQuality();
        }
    }
}
