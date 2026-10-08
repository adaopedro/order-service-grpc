<?php

declare(strict_types=1);

namespace App\Adapter\Persistence;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;
use App\Domain\Repository\OrderRepositoryInterface;
use Exception;
use Hyperf\DbConnection\Db;
use Override;

class OrderRepository implements OrderRepositoryInterface
{
    #[Override]
    public function save(Order $order): void
    {
        $exists = Db::table("orders")->where("id", $order->getId())->exists();

        if ($exists) {
            Db::table("orders")->where("id", $order->getId())->update([
                "user_id" => $order->getUserId(),
                "status" => $order->getStatus()->value,
                "total" => $order->getTotal(),
                "created_at" => $order->getCreatedAt()->format("Y-m-d H:i:s")
            ]);

            Db::table("orders_items")->where("order_id", $order->getId())->delete();
        } else {
            Db::table("orders")->insert([
                'id' => $order->getId(),
                'user_id' => $order->getUserId(),
                'status' => $order->getStatus()->value,
                'total' => $order->getTotal(),
                'created_at' => $order->getCreatedAt()->format('Y-m-d H:i:s'),
            ]);
        }

        foreach ($order->getItems() as $item) {
            Db::table("orders_items")->insert([
                'order_id' => $order->getId(),
                'id' => $item['id'],
                'qty' => $item['qty'],
                'unit_price' => $item['unitPrice'],
            ]);
        }
    }

    #[Override]
    public function findById(string $id): ?Order
    {
        $row = Db::table("orders")->where("id", $id)->first();

        if (!$row) {
            return null;
        }

        return $this->mapRowToOrder($row);
    }

    #[Override]
    public function findByUserId(string $userId, int $limit = 10, int $offset = 0): array
    {
        $orders = Db::table("orders")
            ->where("user_id", $userId)
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->toArray();

        return array_map(
            array: $orders,
            callback: fn($row) => $this->mapRowToOrder($row)
        );
    }

    #[Override]
    public function cancel(string $id): void
    {
        $order = $this->findById($id);

        if (!$order) {
            throw new Exception("Order not found");
        }

        Db::table("orders")->where("id", $id)->update([
            "status" => OrderStatus::CANCELLED->value
        ]);
    }

    private function mapRowToOrder($row): Order
    {
        $items = Db::table("orders_items")
            ->where("order_id", $row->id)
            ->get()
            ->toArray();

        return Order::fromDatabase([
            "id" => $row->id,
            "userId" => $row->user_id,
            "status" => $row->status,
            "items" => $items,
            "total" => $row->total,
            "createdAt" => $row->created_at
        ]);
    }
}
