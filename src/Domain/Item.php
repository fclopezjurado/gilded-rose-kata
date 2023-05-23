<?php

declare(strict_types=1);

namespace App\Domain;

abstract class Item implements \Stringable
{
    protected function __construct(
        private readonly Name $name,
        private readonly SellIn $sellIn,
        private readonly Quality $quality
    ) {
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function sellIn(): SellIn
    {
        return $this->sellIn;
    }

    public function decreaseSellIn(): void
    {
        $this->sellIn->decrease();
    }

    public function quality(): Quality
    {
        return $this->quality;
    }

    public function decreaseQuality(): void
    {
        $this->quality->decrease();
    }

    public function increaseQuality(): void
    {
        $this->quality->increase();
    }

    public function resetQuality(): void
    {
        $this->quality->reset();
    }

    public function hasToBeSoldInLessThan(int $value): bool
    {
        return $this->sellIn->isLessThan($value);
    }

    public function __toString(): string
    {
        return "{$this->name->name()}, {$this->sellIn->value()}, {$this->quality->value()}";
    }

    abstract public function update(): void;
}
