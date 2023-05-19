<?php

declare(strict_types=1);

namespace App\Domain;

final class Quality
{
    /**
     * @var int
     */
    private const MIN_THRESHOLD = 0;

    /**
     * @var int
     */
    private const MAX_THRESHOLD = 50;

    /**
     * @throws QualityOutOfRangeException
     */
    public function __construct(private int $value)
    {
        if ($value > self::MAX_THRESHOLD || $value < self::MIN_THRESHOLD) {
            throw new QualityOutOfRangeException();
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function decrease(): void
    {
        if ($this->value > self::MIN_THRESHOLD) {
            --$this->value;
        }
    }

    public function increase(): void
    {
        if ($this->value < self::MAX_THRESHOLD) {
            ++$this->value;
        }
    }

    public function reset(): void
    {
        $this->value = self::MIN_THRESHOLD;
    }
}
