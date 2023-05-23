<?php

declare(strict_types=1);

namespace App\Domain;

final class Sulfuras extends Item
{
    public function __construct(Name $name, SellIn $sellIn, Quality $quality)
    {
        parent::__construct($name, $sellIn, $quality);
    }

    public function update(): void
    {
    }
}
