<?php

declare(strict_types=1);

namespace App\Application\Dto;

use App\Domain\Enum\OrderStatus;
use DateTime;

readonly class GetOrderOutput
{
    public function __construct(
        public string $id,
        public string $userId,
        public OrderStatus $status,
        public array $items,
        public float $total,
        public DateTime $createdAt
    ) {}
}
