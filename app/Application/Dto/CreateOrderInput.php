<?php

declare(strict_types=1);

namespace App\Application\Dto;

readonly class CreateOrderInput
{
    public function __construct(
        public string $userId,
        public array $items
    ) {}
}
