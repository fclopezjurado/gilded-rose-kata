<?php

declare(strict_types=1);

namespace App\Domain\Model;

use JetBrains\PhpStorm\Pure;

final class BackstagePasses extends Item
{
    private const TEN_DAYS_SELL_IN_THRESHOLD = 10;
    private const FIVE_DAYS_SELL_IN_THRESHOLD = 5;
    private const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function __construct(public int $sellIn, public int $quality)
    {
        parent::__construct(name: self::NAME, sellIn: $sellIn, quality: $quality);
    }

    #[Pure]
    private function hasToBeSoldInLessOrEqualThan(int $days): bool
    {
        return $this->getSellIn()->isLessOrEqualThan($days);
    }

    public function update(): void
    {
        $this->decreaseSellIn();
        $this->increaseQuality();

        if ($this->hasToBeSoldInLessOrEqualThan(self::TEN_DAYS_SELL_IN_THRESHOLD)) {
            $this->increaseQuality();
        }

        if ($this->hasToBeSoldInLessOrEqualThan(self::FIVE_DAYS_SELL_IN_THRESHOLD)) {
            $this->increaseQuality();
        }

        if ($this->hasSellInPassed()) {
            $this->resetQuality();
        }
    }
}
