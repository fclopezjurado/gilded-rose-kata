<?php

declare(strict_types=1);

namespace App\Domain;

final class Name
{
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
}
