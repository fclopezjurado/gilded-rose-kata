<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Exception\QualityOutOfRangeException;
use App\Domain\Model\AgedBrie;
use PHPUnit\Framework\TestCase;

class AgedBrieTest extends TestCase
{
    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToIncreaseItemQuality
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldIncreaseItemQuality(array $data): void
    {
        $item = new AgedBrie(sellIn: $data['sellIn'], quality: $data['quality']);

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
        $item = new AgedBrie(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'] + 2, $item->getQuality()->getValue());
    }

    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToNotIncreaseItemQuality
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldNotDegradeItemQuality(array $data): void
    {
        $item = new AgedBrie(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'], $item->getQuality()->getValue());
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideDataToIncreaseItemQuality(): iterable
    {
        yield [
            [
                'sellIn' => 5,
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
                'sellIn' => 0,
                'quality' => 5,
            ],
        ];
        yield [
            [
                'sellIn' => 0,
                'quality' => 8,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideDataToNotIncreaseItemQuality(): iterable
    {
        yield [
            [
                'sellIn' => 0,
                'quality' => 50,
            ],
        ];
    }
}
