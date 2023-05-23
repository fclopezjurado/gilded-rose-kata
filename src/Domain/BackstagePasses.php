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

    public function __construct(Name $name, SellIn $sellIn, Quality $quality)
    {
        parent::__construct($name, $sellIn, $quality);
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->increaseQuality();

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
