<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\SellIn;
use PHPUnit\Framework\TestCase;

class SellInTest extends TestCase
{
    /**
     * @param array{value: int} $data
     * @dataProvider providePositiveValues
     */
    public function testShouldCreateSellIn(array $data): void
    {
        $sellIn = new SellIn($data['value']);

        self::assertSame($data['value'], $sellIn->getValue());

        $sellIn->decrease();

        self::assertSame(--$data['value'], $sellIn->getValue());
        self::assertFalse($sellIn->hasPassed());
        self::assertTrue($sellIn->isLessOrEqualThan(PHP_INT_MAX));
        self::assertSame(strval($sellIn->getValue()), (string) $sellIn);
    }


    /**
     * @param array{value: int} $data
     * @dataProvider provideNegativeValues
     */
    public function testShouldValueHasPassed(array $data): void
    {
        $sellIn = new SellIn($data['value']);

        self::assertTrue($sellIn->hasPassed());
    }

    /**
     * @return iterable<array<int, array{value: int}>>
     */
    public function providePositiveValues(): iterable
    {
        yield [
            [
                'value' => 9,
            ],
        ];
        yield [
            [
                'value' => 6,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{value: int}>>
     */
    public function provideNegativeValues(): iterable
    {
        yield [
            [
                'value' => -4,
            ],
        ];
        yield [
            [
                'value' => -9,
            ],
        ];
    }
}
