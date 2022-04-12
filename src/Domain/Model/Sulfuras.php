<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class Sulfuras extends Item
{
    private const NAME = 'Sulfuras, Hand of Ragnaros';

    public function __construct(public int $sellIn, public int $quality)
    {
        parent::__construct(name: self::NAME, sellIn: $sellIn, quality: $quality);
    }

    public function update(): void
    {
    }
}
