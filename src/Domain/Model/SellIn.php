<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class SellIn
{
    private const MIN_THRESHOLD = 0;

    public function __construct(private int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function decrease(): void
    {
        --$this->value;
    }

    public function hasPassed(): bool
    {
        return $this->value < self::MIN_THRESHOLD;
    }

    public function isLessOrEqualThan(int $value): bool
    {
        return $this->value <= $value;
    }

    public function __toString(): string
    {
        return "$this->value";
    }
}
