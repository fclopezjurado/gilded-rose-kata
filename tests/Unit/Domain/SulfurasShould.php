<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\ItemFactory;
use App\Domain\QualityOutOfRangeException;
use App\Domain\Sulfuras;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class SulfurasShould extends TestCase
{
    /**
     * @param array{sellIn: int, quality: int, name: string, hasToBeSoldInLessThan: int,
     *     outputTemplate: string} $data
     *
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Creates sulfuras item')]
    public function create(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        self::assertInstanceOf(Sulfuras::class, $item);
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
    #[TestDox('Does not create sulfuras item')]
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
    #[TestDox('Updates sulfuras item')]
    public function update(array $data): void
    {
        $item = ItemFactory::basedOn($data['name'], $data['sellIn'], $data['quality']);

        $item->update();

        self::assertSame($data['sellIn'], $item->sellIn()->value());
        self::assertSame($data['quality'], $item->quality()->value());
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
                'name' => 'Sulfuras, Hand of Ragnaros',
                'hasToBeSoldInLessThan' => 20,
                'outputTemplate' => 'Sulfuras, Hand of Ragnaros, 16, 36',
            ],
        ];
        yield [
            [
                'sellIn' => 18,
                'quality' => 33,
                'name' => 'Sulfuras, Hand of Ragnaros',
                'hasToBeSoldInLessThan' => 20,
                'outputTemplate' => 'Sulfuras, Hand of Ragnaros, 18, 33',
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
                'name' => 'Sulfuras, Hand of Ragnaros',
            ],
        ];
        yield [
            [
                'sellIn' => 18,
                'quality' => 68,
                'name' => 'Sulfuras, Hand of Ragnaros',
            ],
        ];
    }
}
