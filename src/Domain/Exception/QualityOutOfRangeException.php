<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class QualityOutOfRangeException extends Exception
{
    private const MESSAGE = 'Item quality value is out of range';

    #[Pure]
    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
