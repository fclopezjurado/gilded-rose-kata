<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Exception\QualityOutOfRangeException;
use App\Domain\Model\Quality;
use PHPUnit\Framework\TestCase;

class QualityTest extends TestCase
{
    /**
     * @param array{value: int} $data
     * @dataProvider provideValidData
     * @throws QualityOutOfRangeException
     */
    public function testShouldCreateQuality(array $data): void
    {
        $quality = new Quality($data['value']);

        self::assertSame($data['value'], $quality->getValue());

        $quality->increase();

        self::assertSame(++$data['value'], $quality->getValue());

        $quality->decrease();

        self::assertSame(--$data['value'], $quality->getValue());
        self::assertSame(strval($data['value']), (string) $quality);

        $quality->reset();

        self::assertSame(expected: 0, actual: $quality->getValue());
    }

    /**
     * @param array{value: int} $data
     * @dataProvider provideInvalidData
     * @throws QualityOutOfRangeException
     */
    public function testShouldNotCreateQuality(array $data): void
    {
        self::expectException(QualityOutOfRangeException::class);
        new Quality($data['value']);
    }

    /**
     * @return iterable<array<int, array{value: int}>>
     */
    public function provideValidData(): iterable
    {
        yield [
            [
                'value' => 24,
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
    public function provideInvalidData(): iterable
    {
        yield [
            [
                'value' => 87,
            ],
        ];
        yield [
            [
                'value' => -4,
            ],
        ];
    }
}
