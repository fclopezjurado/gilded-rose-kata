<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Exception\QualityOutOfRangeException;
use App\Domain\Model\Standard;
use PHPUnit\Framework\TestCase;

class StandardTest extends TestCase
{
    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToDegradeItem
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldDegradeItem(array $data): void
    {
        $item = new Standard(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'] - 1, $item->getQuality()->getValue());
    }

    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToDegradeItemTwiceAsFast
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldDegradeItemTwiceAsFast(array $data): void
    {
        $item = new Standard(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'] - 2, $item->getQuality()->getValue());
    }

    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideDataToNotDegradeItemQuality
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldNotDegradeItemQuality(array $data): void
    {
        $item = new Standard(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'] - 1, $item->getSellIn()->getValue());
        self::assertSame($data['quality'], $item->getQuality()->getValue());
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideDataToDegradeItem(): iterable
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
    public function provideDataToDegradeItemTwiceAsFast(): iterable
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
    public function provideDataToNotDegradeItemQuality(): iterable
    {
        yield [
            [
                'sellIn' => 0,
                'quality' => 0,
            ],
        ];
    }
}
