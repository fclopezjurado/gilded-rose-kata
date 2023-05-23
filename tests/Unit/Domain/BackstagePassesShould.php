<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\BackstagePasses;
use App\Domain\ItemFactory;
use App\Domain\QualityOutOfRangeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
class BackstagePassesShould extends TestCase
{
    /**
     * @param array{sellIn: int, quality: int, name: string, hasToBeSoldInLessThan: int,
     *     outputTemplate: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Creates backstage passes item')]
    public function create(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        self::assertInstanceOf(BackstagePasses::class, $item);
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
    #[TestDox('Does not create backstage passes item')]
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
    #[TestDox('Updates backstage passes item')]
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
    #[TestDox('Updates backstage passes item increasing quality twice')]
    public function updateIncreasingQualityTwice(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        $item->update();

        self::assertSame(--$data['sellIn'], $item->sellIn()->value());
        self::assertSame($data['quality'] + 2, $item->quality()->value());
    }

    /**
     * @param array{sellIn: int, quality: int, name: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideDataToIncreaseQualityThrice')]
    #[TestDox('Updates backstage passes item increasing quality thrice')]
    public function updateIncreasingQualityThrice(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        $item->update();

        self::assertSame(--$data['sellIn'], $item->sellIn()->value());
        self::assertSame($data['quality'] + 3, $item->quality()->value());
    }

    /**
     * @param array{sellIn: int, quality: int, name: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideDataToResetQuality')]
    #[TestDox('Updates backstage passes item initializing quality')]
    public function updateInitializingQuality(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        $item->update();

        self::assertSame(--$data['sellIn'], $item->sellIn()->value());
        self::assertEmpty($item->quality()->value());
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
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
                'hasToBeSoldInLessThan' => 20,
                'outputTemplate' => 'Backstage passes to a TAFKAL80ETC concert, 16, 36',
            ],
        ];
        yield [
            [
                'sellIn' => 18,
                'quality' => 33,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
                'hasToBeSoldInLessThan' => 20,
                'outputTemplate' => 'Backstage passes to a TAFKAL80ETC concert, 18, 33',
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
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
            ],
        ];
        yield [
            [
                'sellIn' => 18,
                'quality' => 68,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
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
                'sellIn' => 9,
                'quality' => 14,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
            ],
        ];
        yield [
            [
                'sellIn' => 8,
                'quality' => 38,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int, name: string}>>
     */
    public static function provideDataToIncreaseQualityThrice(): iterable
    {
        yield [
            [
                'sellIn' => 4,
                'quality' => 14,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
            ],
        ];
        yield [
            [
                'sellIn' => 3,
                'quality' => 38,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int, name: string}>>
     */
    public static function provideDataToResetQuality(): iterable
    {
        yield [
            [
                'sellIn' => 0,
                'quality' => 14,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
            ],
        ];
        yield [
            [
                'sellIn' => 0,
                'quality' => 38,
                'name' => 'Backstage passes to a TAFKAL80ETC concert',
            ],
        ];
    }
}
