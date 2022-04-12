<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Exception\QualityOutOfRangeException;
use App\Domain\Model\Sulfuras;
use PHPUnit\Framework\TestCase;

class SulfurasTest extends TestCase
{
    /**
     * @param array{sellIn: int, quality: int} $data
     * @dataProvider provideData
     *
     * @throws QualityOutOfRangeException
     */
    public function testShouldUpdateItem(array $data): void
    {
        $item = new Sulfuras(sellIn: $data['sellIn'], quality: $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'], $item->getSellIn()->getValue());
        self::assertSame($data['quality'], $item->getQuality()->getValue());
    }

    /**
     * @return iterable<array<int, array{sellIn: int, quality: int}>>
     */
    public function provideData(): iterable
    {
        yield [
            [
                'sellIn' => 5,
                'quality' => 5,
            ],
        ];
    }
}
