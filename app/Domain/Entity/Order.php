<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\OrderStatus;
use DateTime;

class Order {
    private function __construct(
        private string $id,
        private string $userId,
        private OrderStatus $status,
        private array $items,
        private float $total,
        private DateTime $createdAt
    )
    {}

    public function getId(): string { return $this->id; }
    public function getUserId(): string { return $this->userId; }
    public function getStatus(): OrderStatus { return $this->status; }
    public function getItems(): array { return $this->items; }
    public function getTotal(): float { return $this->total; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }

    public static function create(
        string $id,
        string $userId,
        array $items,
        float $total
    ): self {
        return new self(
            id: $id,
            userId: $userId,
            status: OrderStatus::PENDING,
            items: $items,
            total: $total,
            createdAt: new DateTime(),
        );
    }

    public static function fromDatabase (array $data): self {
        return new self(
            id: $data['id'],
            userId: $data['userId'],
            status: OrderStatus::from($data['status']),
            items: $data['items'],
            total: $data['total'],
            createdAt: new DateTime($data['createdAt']),
        );
    }
}