<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\QualityOutOfRangeException;
use JetBrains\PhpStorm\Pure;

abstract class Item
{
    private SellIn $sellIn;
    private Quality $quality;

    /**
     * @throws QualityOutOfRangeException
     */
    public function __construct(private string $name, int $sellIn, int $quality)
    {
        $this->sellIn = new SellIn($sellIn);
        $this->quality = new Quality($quality);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSellIn(): SellIn
    {
        return $this->sellIn;
    }

    public function decreaseSellIn(): void
    {
        $this->sellIn->decrease();
    }

    #[Pure]
    public function hasSellInPassed(): bool
    {
        return $this->sellIn->hasPassed();
    }

    public function getQuality(): Quality
    {
        return $this->quality;
    }

    public function increaseQuality(): void
    {
        $this->quality->increase();
    }

    public function decreaseQuality(): void
    {
        $this->quality->decrease();
    }

    public function resetQuality(): void
    {
        $this->quality->reset();
    }

    abstract public function update(): void;

    public function __toString(): string
    {
        return "$this->name, $this->sellIn, $this->quality";
    }
}
