<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Dto\CreateOrderInput;
use App\Application\Dto\CreateOrderOutput;
use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;
use App\Domain\Repository\OrderRepositoryInterface as RepositoryOrderRepositoryInterface;
use DateTime;

class CreateOrderUseCase
{
    public function __construct(private RepositoryOrderRepositoryInterface $orderRepository) {}

    public function execute(CreateOrderInput $input): CreateOrderOutput
    {
        if (empty($input->items)) {
            throw new \Exception("Order must have at least one item");
        }

        $total = array_reduce(
            array: $input->items,
            callback: fn($sum, $item) => $sum + ($item["qty"] * $item["unitPrice"]),
            initial: 0
        );

        $order = Order::create(
            id: (string) rand(1000, 999999),
            userId: $input->userId,
            items: $input->items,
            total: $total,
        );

        $this->orderRepository->save($order);

        return new CreateOrderOutput(
            id: $order->getId(),
            userId: $order->getUserId(),
            status: $order->getStatus(),
            items: $order->getItems(),
            total: $order->getTotal(),
            createdAt: $order->getCreatedAt()
        );
    }
}
