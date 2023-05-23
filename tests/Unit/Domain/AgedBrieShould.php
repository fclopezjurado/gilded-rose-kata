<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\AgedBrie;
use App\Domain\ItemFactory;
use App\Domain\QualityOutOfRangeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class AgedBrieShould extends TestCase
{
    /**
     * @param array{sellIn: int, quality: int, name: string, hasToBeSoldInLessThan: int,
     *     outputTemplate: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Creates aged brie item')]
    public function create(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        self::assertInstanceOf(AgedBrie::class, $item);
        self::assertSame($data['sellIn'], $item->sellIn()->value());
        self::assertSame($data['quality'], $item->quality()->value());
        self::assertSame($data['name'], $item->name()->name());
        self::assertSame($data['outputTemplate'], (string) $item);

        $item->decreaseSellIn();
        $item->decreaseQuality();
        $item->increaseQuality();

        self::assertSame(--$data['sellIn'], $item->sellIn()->value());
        self::assertSame($data['quality'], $item->quality()->value());
        self::assertTrue($item->hasToBeSoldInLessThan($data['hasToBeSoldInLessThan']));

        $item->resetQuality();

        self::assertEmpty($item->quality()->value());
    }

    /**
     * @param array{sellIn: int, quality: int, name: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideWrongValues')]
    #[TestDox('Does not create aged brie item')]
    public function notCreate(array $data): void
    {
        self::expectException(QualityOutOfRangeException::class);
        ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);
    }

    /**
     * @param array{sellIn: int, quality: int, name: string, hasToBeSoldInLessThan: int,
     *     outputTemplate: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Updates aged brie item')]
    public function update(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        $item->update();

        self::assertSame(--$data['sellIn'], $item->sellIn()->value());
        self::assertSame(++$data['quality'], $item->quality()->value());
    }

    /**
     * @param array{sellIn: int, quality: int, name: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideDataToIncreaseQualityTwice')]
    #[TestDox('Updates aged brie item increasing quality twice')]
    public function updateIncreasingQualityTwice(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        $item->update();

        self::assertSame(--$data['sellIn'], $item->sellIn()->value());
        self::assertSame($data['quality'] + 2, $item->quality()->value());
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int, name: string, hasToBeSoldInLessThan: int,
     *     outputTemplate: string}>>
     */
    public static function provideRightValues(): iterable
    {
        yield [
            [
                'sellIn' => 16,
                'quality' => 36,
                'name' => 'Aged Brie',
                'hasToBeSoldInLessThan' => 20,
                'outputTemplate' => 'Aged Brie, 16, 36',
            ],
        ];
        yield [
            [
                'sellIn' => 18,
                'quality' => 33,
                'name' => 'Aged Brie',
                'hasToBeSoldInLessThan' => 20,
                'outputTemplate' => 'Aged Brie, 18, 33',
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int, name: string}>>
     */
    public static function provideWrongValues(): iterable
    {
        yield [
            [
                'sellIn' => 16,
                'quality' => -1,
                'name' => 'Aged Brie',
            ],
        ];
        yield [
            [
                'sellIn' => 18,
                'quality' => 68,
                'name' => 'Aged Brie',
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int, name: string}>>
     */
    public static function provideDataToIncreaseQualityTwice(): iterable
    {
        yield [
            [
                'sellIn' => 0,
                'quality' => 14,
                'name' => 'Aged Brie',
            ],
        ];
        yield [
            [
                'sellIn' => 0,
                'quality' => 38,
                'name' => 'Aged Brie',
            ],
        ];
    }
}
