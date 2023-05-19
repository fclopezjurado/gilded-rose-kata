<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Name;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class NameShould extends TestCase
{
    /**
     * @param array{initialName: string, updatedName: string} $data
     */
    #[Test]
    #[DataProvider('provideNames')]
    #[TestDox('Creates an instance of Name')]
    public function create(array $data): void
    {
        $name = new Name($data['initialName']);

        self::assertInstanceOf(Name::class, $name);
    }

    /**
     * @param array{initialName: string, updatedName: string} $data
     */
    #[Test]
    #[DataProvider('provideNames')]
    #[TestDox('Updates an instance of Name')]
    public function update(array $data): void
    {
        $name = new Name($data['initialName']);

        self::assertSame($data['updatedName'], $name->setName($data['updatedName']));
    }

    /**
     * @param array{initialName: string, updatedName: string} $data
     */
    #[Test]
    #[DataProvider('provideNames')]
    #[TestDox('Gets a name')]
    public function get(array $data): void
    {
        $name = new Name($data['initialName']);

        self::assertSame($data['initialName'], $name->name());
    }

    /**
     * @return iterable<array<int, array{initialName: string, updatedName: string}>>
     */
    public static function provideNames(): iterable
    {
        yield [
            [
                'initialName' => 'Joseph',
                'updatedName' => 'Peter',
            ],
        ];
        yield [
            [
                'initialName' => 'John',
                'updatedName' => 'Robert',
            ],
        ];
    }
}
