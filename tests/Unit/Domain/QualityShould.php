<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Quality;
use App\Domain\QualityOutOfRangeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class QualityShould extends TestCase
{
    /**
     * @param array{value: int} $data
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Creates an instance of Quality')]
    public function create(array $data): void
    {
        $quality = new Quality($data['value']);

        self::assertInstanceOf(Quality::class, $quality);
    }

    /**
     * @param array{value: int} $data
     */
    #[Test]
    #[DataProvider('provideWrongValues')]
    #[TestDox('Does not create an instance of Quality due to value is out of range')]
    public function notCreateDueToOutOfRange(array $data): void
    {
        self::expectException(QualityOutOfRangeException::class);
        new Quality($data['value']);
    }

    /**
     * @param array{value: int} $data
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Gets item quality')]
    public function get(array $data): void
    {
        $quality = new Quality($data['value']);

        self::assertSame($data['value'], $quality->value());
    }

    /**
     * @param array{value: int} $data
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Decreases item quality')]
    public function decrease(array $data): void
    {
        $quality = new Quality($data['value']);
        $quality->decrease();

        self::assertSame(--$data['value'], $quality->value());
    }

    /**
     * @param array{value: int} $data
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideNotDecreasableValues')]
    #[TestDox('Does not decrease item quality')]
    public function notDecrease(array $data): void
    {
        $quality = new Quality($data['value']);
        $quality->decrease();

        self::assertSame($data['value'], $quality->value());
    }

    /**
     * @param array{value: int} $data
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Increases item quality')]
    public function increase(array $data): void
    {
        $quality = new Quality($data['value']);
        $quality->increase();

        self::assertSame(++$data['value'], $quality->value());
    }

    /**
     * @param array{value: int} $data
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideNotIncreasableValues')]
    #[TestDox('Does not increase item quality')]
    public function notIncrease(array $data): void
    {
        $quality = new Quality($data['value']);
        $quality->increase();

        self::assertSame($data['value'], $quality->value());
    }

    /**
     * @param array{value: int} $data
     * @throws QualityOutOfRangeException
     */
    #[Test]
    #[DataProvider('provideRightValues')]
    #[TestDox('Resets item quality')]
    public function reset(array $data): void
    {
        $quality = new Quality($data['value']);
        $quality->reset();

        self::assertEmpty($quality->value());
    }

    /**
     * @return iterable<array<int, array{value: int}>>
     */
    public static function provideRightValues(): iterable
    {
        yield [
            [
                'value' => 45,
            ],
        ];
        yield [
            [
                'value' => 38,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{value: int}>>
     */
    public static function provideWrongValues(): iterable
    {
        yield [
            [
                'value' => -1,
            ],
        ];
        yield [
            [
                'value' => -50,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{value: int}>>
     */
    public static function provideNotDecreasableValues(): iterable
    {
        yield [
            [
                'value' => 0,
            ],
        ];
    }

    /**
     * @return iterable<array<int, array{value: int}>>
     */
    public static function provideNotIncreasableValues(): iterable
    {
        yield [
            [
                'value' => 50,
            ],
        ];
    }
}
