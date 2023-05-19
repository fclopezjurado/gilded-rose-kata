<?php

declare(strict_types=1);

namespace App\Domain;

final class Standard extends Item
{
    /**
     * @var int
     */
    private const DOUBLE_QUALITY_DECREASE_SELL_IN_THRESHOLD = 0;
    private const NAME = 'Standard';

    public function __construct(SellIn $sellIn, Quality $quality)
    {
        parent::__construct(new Name(self::NAME), $sellIn, $quality);
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