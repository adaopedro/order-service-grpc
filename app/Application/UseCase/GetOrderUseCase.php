<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Dto\GetOrderOutput;
use App\Domain\Repository\OrderRepositoryInterface as RepositoryOrderRepositoryInterface;
use Exception;

class GetOrderUseCase
{
    public function __construct(private RepositoryOrderRepositoryInterface $orderRepository) {}

    public function execute(string $orderId): GetOrderOutput
    {
        $order = $this->orderRepository->findById($orderId);

        if (!$order) {
            throw new Exception("Order not found");
        }

        return new GetOrderOutput(
            id: $order->getId(),
            userId: $order->getUserId(),
            status: $order->getStatus(),
            items: $order->getItems(),
            total: $order->getTotal(),
            createdAt: $order->getCreatedAt()
        );
    }
}
