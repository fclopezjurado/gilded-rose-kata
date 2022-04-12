<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application;

use App\Application\GildedRose;
use App\Domain\Exception\QualityOutOfRangeException;
use App\Domain\Model\AgedBrie;
use App\Domain\Model\BackstagePasses;
use App\Domain\Model\Conjured;
use App\Domain\Model\Item;
use App\Domain\Model\Standard;
use App\Domain\Model\Sulfuras;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @param Item[] $items
     * @dataProvider provideItems
     */
    public function testShouldUpdateItems(array $items): void
    {
        $useCase = new GildedRose(items: $items);

        $useCase->update();

        $processedItems = $useCase->getItems();

        for ($index = 0; $index < count($items); ++$index) {
            self::assertSame($items[$index]->getName(), $processedItems[$index]->getName());
            self::assertSame($items[$index]->getQuality(), $processedItems[$index]->getQuality());
            self::assertSame($items[$index]->getSellIn(), $processedItems[$index]->getSellIn());
        }
    }

    /**
     * @return iterable<array<int, Item[]>>
     *
     * @throws QualityOutOfRangeException
     */
    public function provideItems(): iterable
    {
        yield [
            [
                new AgedBrie(sellIn: 0, quality: 5),
                new BackstagePasses(sellIn: 12, quality: 5),
                new Conjured(sellIn: 14, quality: 15),
                new Standard(sellIn: 11, quality: 6),
                new Sulfuras(sellIn: 8, quality: 3),
            ],
        ];
    }
}
