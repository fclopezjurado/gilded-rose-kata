<?php

declare(strict_types=1);

namespace App\Domain;

class QualityOutOfRangeException extends \Exception
{
    /**
     * @var string
     */
    private const MESSAGE = 'Quality is out of range';

    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }
}
