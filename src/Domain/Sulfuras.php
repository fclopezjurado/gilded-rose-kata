<?php

declare(strict_types=1);

namespace App\Domain;

final class Sulfuras extends Item
{
    private const NAME = 'Sulfuras, Hand of Ragnaros';

    public function __construct(SellIn $sellIn, Quality $quality)
    {
        parent::__construct(new Name(self::NAME), $sellIn, $quality);
    }

    public function update(): void
    {
    }
}
