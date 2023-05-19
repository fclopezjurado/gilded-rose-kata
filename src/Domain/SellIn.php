<?php

declare(strict_types=1);

namespace App\Domain;

final class SellIn
{
    public function __construct(private int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function setValue(int $value): int
    {
        return $this->value = $value;
    }

    public function decrease(): void
    {
        --$this->value;
    }

    public function isLessThan(int $value): bool
    {
        return $this->value < $value;
    }
}
