<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Exception\QualityOutOfRangeException;
use App\Domain\Model\BackstagePasses;
use PHPUnit\Framework\TestCase;

class BackstagePassesTest extends TestCase
{
    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToIncreaseItemQuality
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldIncreaseItemQuality(array $data): void
    {
        $item = new BackstagePasses(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'] + 1, $item->getQuality()->getValue());
    }

    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToIncreaseItemQualityTwiceAsFast
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldIncreaseItemQualityTwiceAsFast(array $data): void
    {
        $item = new BackstagePasses(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'] + 2, $item->getQuality()->getValue());
    }

    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToIncreaseItemQualityThriceAsFast
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldIncreaseItemQualityThriceAsFast(array $data): void
    {
        $item = new BackstagePasses(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'] + 3, $item->getQuality()->getValue());
    }

    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToResetItemQuality
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldResetItemQuality(array $data): void
    {
        $item = new BackstagePasses(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertEmpty($item->getQuality()->getValue());
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideDataToIncreaseItemQuality(): iterable
    {
        yield [
            [
                'sellIn' => 12,
                'quality' => 5,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideDataToIncreaseItemQualityTwiceAsFast(): iterable
    {
        yield [
            [
                'sellIn' => 11,
                'quality' => 5,
            ],
        ];
        yield [
            [
                'sellIn' => 9,
                'quality' => 8,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideDataToIncreaseItemQualityThriceAsFast(): iterable
    {
        yield [
            [
                'sellIn' => 6,
                'quality' => 5,
            ],
        ];
        yield [
            [
                'sellIn' => 5,
                'quality' => 8,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideDataToResetItemQuality(): iterable
    {
        yield [
            [
                'sellIn' => 0,
                'quality' => 50,
            ],
        ];
    }
}
