<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\SellIn;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class SellInShould extends TestCase
{
    /**
     * @param array{initialValue: int, updatedValue: int, minValue: int} $data
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Creates an instance of SellIn')]
    public function create(array $data): void
    {
        $sellIn = new SellIn($data['initialValue']);

        self::assertInstanceOf(SellIn::class, $sellIn);
    }

    /**
     * @param array{initialValue: int, updatedValue: int, minValue: int} $data
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Updates an instance of SellIn')]
    public function update(array $data): void
    {
        $sellIn = new SellIn($data['initialValue']);

        self::assertSame($data['updatedValue'], $sellIn->setValue($data['updatedValue']));
    }

    /**
     * @param array{initialValue: int, updatedValue: int, minValue: int} $data
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Gets a max limit of days to sell an item')]
    public function get(array $data): void
    {
        $sellIn = new SellIn($data['initialValue']);

        self::assertSame($data['initialValue'], $sellIn->value());
    }

    /**
     * @param array{initialValue: int, updatedValue: int, minValue: int} $data
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Decrease max limit of days to sell an item')]
    public function decrease(array $data): void
    {
        $sellIn = new SellIn($data['initialValue']);
        $sellIn->decrease();

        self::assertSame(--$data['initialValue'], $sellIn->value());
    }

    /**
     * @param array{initialValue: int, updatedValue: int, minValue: int} $data
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Max limit of days to sell an item is less than a value')]
    public function isLessThan(array $data): void
    {
        $sellIn = new SellIn($data['initialValue']);

        self::assertTrue($sellIn->isLessThan($data['minValue']));
    }

    /**
     * @param array{initialValue: int, updatedValue: int, minValue: int} $data
     */
    #[Test]
    #[DataProvider('provideWrongValues')]
    #[TestDox('Max limit of days to sell an item is not less than a value')]
    public function isNotLessThan(array $data): void
    {
        $sellIn = new SellIn($data['initialValue']);

        self::assertFalse($sellIn->isLessThan($data['minValue']));
    }

    /**
     * @return iterable<array<int, array{initialValue: int, updatedValue: int, minValue: int}>>
     */
    public static function provideRightValues(): iterable
    {
        yield [
            [
                'initialValue' => 45,
                'updatedValue' => 12,
                'minValue' => 80,
            ],
        ];
        yield [
            [
                'initialValue' => 89,
                'updatedValue' => 23,
                'minValue' => 98,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{initialValue: int, updatedValue: int}>>
     */
    public static function provideWrongValues(): iterable
    {
        yield [
            [
                'initialValue' => 45,
                'updatedValue' => 12,
                'minValue' => 0,
            ],
        ];
        yield [
            [
                'initialValue' => 89,
                'updatedValue' => 23,
                'minValue' => 1,
            ],
        ];
    }
}
