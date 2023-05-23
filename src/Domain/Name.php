<?php

declare(strict_types=1);

namespace App\Domain;

final class Name
{
    /**
     * @var string
     */
    private const AGED_BRIE_NAME = 'Aged Brie';
    /**
     * @var string
     */
    private const BACKSTAGE_PASSES_NAME = 'Backstage passes to a TAFKAL80ETC concert';
    /**
     * @var string
     */
    private const SULFURAS_NAME = 'Sulfuras, Hand of Ragnaros';

    public function __construct(private string $name)
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    public function isAgedBrie(): bool
    {
        return self::AGED_BRIE_NAME === $this->name;
    }

    public function isBackstagePasses(): bool
    {
        return self::BACKSTAGE_PASSES_NAME === $this->name;
    }

    public function isSulfuras(): bool
    {
        return self::SULFURAS_NAME === $this->name;
    }
}
