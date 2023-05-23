<?php

declare(strict_types=1);

namespace App\Domain;

final class ItemFactory
{
    /**
     * @throws QualityOutOfRangeException
     */
    public static function basedOn(string $name, int $sellIn, int $quality): Item
    {
        $itemName = new Name($name);
        $itemSellIn = new SellIn($sellIn);
        $itemQuality = new Quality($quality);

        if ($itemName->isAgedBrie()) {
            return new AgedBrie($itemName, $itemSellIn, $itemQuality);
        }

        if ($itemName->isBackstagePasses()) {
            return new BackstagePasses($itemName, $itemSellIn, $itemQuality);
        }

        if ($itemName->isSulfuras()) {
            return new Sulfuras($itemName, $itemSellIn, $itemQuality);
        }

        return new Standard($itemName, $itemSellIn, $itemQuality);
    }
}
