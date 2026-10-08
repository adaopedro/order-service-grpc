<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
    public function findById(string $id): ?Order;
    public function findByUserId(string $userId, int $limit, int $offset): array;
    public function cancel(string $id): void;
}
