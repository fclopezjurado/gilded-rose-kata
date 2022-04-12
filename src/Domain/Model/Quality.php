<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\QualityOutOfRangeException;

final class Quality
{
    private const MIN_THRESHOLD = 0;
    private const MAX_THRESHOLD = 50;

    /**
     * @throws QualityOutOfRangeException
     */
    public function __construct(private int $value)
    {
        if ($value < self::MIN_THRESHOLD || $value > self::MAX_THRESHOLD) {
            throw new QualityOutOfRangeException();
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function increase(): void
    {
        if ($this->value < self::MAX_THRESHOLD) {
            ++$this->value;
        }
    }

    public function decrease(): void
    {
        if ($this->value > self::MIN_THRESHOLD) {
            --$this->value;
        }
    }

    public function reset(): void
    {
        $this->value = self::MIN_THRESHOLD;
    }

    public function __toString(): string
    {
        return "$this->value";
    }
}
