<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application;

use App\Application\GildedRose;
use App\Domain\Item;
use App\Domain\ItemFactory;
use App\Domain\QualityOutOfRangeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class GildedRoseShould extends TestCase
{
    /**
     * @param array{standard: array{name: string, sellIn: int, quality: int},
     *     sulfuras: array{name: string, sellIn: int, quality: int},
     *     agedBrie: array{name: string, sellIn: int, quality: int},
     *     backstagePasses: array{name: string, sellIn: int, quality: int}} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Creates gilded rose instance')]
    public function create(array $data): void
    {
        $items = array_map(fn (array $itemData): Item => ItemFactory::basedOn(
            $itemData['name'],
            $itemData['sellIn'],
            $itemData['quality']
        ), $data);
        $gildedRose = new GildedRose($items);

        self::assertInstanceOf(GildedRose::class, $gildedRose);
    }

    /**
     * @param array{standard: array{name: string, sellIn: int, quality: int},
     *     sulfuras: array{name: string, sellIn: int, quality: int},
     *     agedBrie: array{name: string, sellIn: int, quality: int},
     *     backstagePasses: array{name: string, sellIn: int, quality: int}} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Updates all items')]
    public function update(array $data): void
    {
        $items = array_map(fn (array $itemData): Item => ItemFactory::basedOn(
            $itemData['name'],
            $itemData['sellIn'],
            $itemData['quality']
        ), array_values($data));
        $gildedRose = new GildedRose($items);

        $gildedRose->update();

        $updatedItems = $gildedRose->items();
        list($standard, $sulfuras, $agedBrie, $backstagePasses) = $updatedItems;

        self::assertSame(--$data['standard']['sellIn'], $standard->sellIn()->value());
        self::assertSame(--$data['standard']['quality'], $standard->quality()->value());
        self::assertSame($data['sulfuras']['sellIn'], $sulfuras->sellIn()->value());
        self::assertSame($data['sulfuras']['quality'], $sulfuras->quality()->value());
        self::assertSame(--$data['agedBrie']['sellIn'], $agedBrie->sellIn()->value());
        self::assertSame(++$data['agedBrie']['quality'], $agedBrie->quality()->value());
        self::assertSame(--$data['backstagePasses']['sellIn'], $backstagePasses->sellIn()->value());
        self::assertSame(++$data['backstagePasses']['quality'], $backstagePasses->quality()->value());
    }

    /**
     * @return iterable<array<int, array{standard: array{name: string, sellIn: int, quality: int},
     *     sulfuras: array{name: string, sellIn: int, quality: int},
     *     agedBrie: array{name: string, sellIn: int, quality: int},
     *     backstagePasses: array{name: string, sellIn: int, quality: int}}>>
     */
    public static function provideRightValues(): iterable
    {
        yield [
            [
                'standard' => [
                    'name' => 'Standard',
                    'sellIn' => 16,
                    'quality' => 36,
                ],
                'sulfuras' => [
                    'name' => 'Sulfuras, Hand of Ragnaros',
                    'sellIn' => 17,
                    'quality' => 37,
                ],
                'agedBrie' => [
                    'name' => 'Aged Brie',
                    'sellIn' => 18,
                    'quality' => 38,
                ],
                'backstagePasses' => [
                    'name' => 'Backstage passes to a TAFKAL80ETC concert',
                    'sellIn' => 19,
                    'quality' => 39,
                ],
            ],
        ];
    }
}
