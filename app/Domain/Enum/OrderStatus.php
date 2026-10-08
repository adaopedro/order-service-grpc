<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum OrderStatus: int
{
    case PENDING = 1;
    case PAID = 2;
    case CANCELLED = 3;
}
