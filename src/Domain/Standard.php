<?php

declare(strict_types=1);

namespace App\Domain;

final class Standard extends Item
{
    /**
     * @var int
     */
    private const DOUBLE_QUALITY_DECREASE_SELL_IN_THRESHOLD = 0;

    public function __construct(Name $name, SellIn $sellIn, Quality $quality)
    {
        parent::__construct($name, $sellIn, $quality);
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();

        if ($this->hasToBeSoldInLessThan(self::DOUBLE_QUALITY_DECREASE_SELL_IN_THRESHOLD)) {
            $this->decreaseQuality();
        }
    }
}