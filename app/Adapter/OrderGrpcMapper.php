<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Application\Dto\CreateOrderInput;
use App\Application\Dto\CreateOrderOutput;
use App\Grpc\Message\CreateOrderRequest;
use App\Grpc\Message\OrderItem as GrpcOrderItem;
use App\Grpc\Message\Order as GrpcOrder;
use Google\Protobuf\Timestamp;

class OrderGrpcMapper
{
    public function createOrderGrpcToInput(CreateOrderRequest $request): CreateOrderInput
    {
        return new CreateOrderInput(
            userId: $request->getUserId(),
            items: array_map(
                array: iterator_to_array($request->getItems(), true),
                callback: fn(GrpcOrderItem $item) => ["id" => $item->getId(), "qty" => $item->getQty(), "unitPrice" => $item->getUnitPrice()]
            )
        );
    }

    public function outputToGrpcOrder(CreateOrderOutput $output): GrpcOrder
    {
        $timestamp = new Timestamp();
        $timestamp->fromDateTime($output->createdAt);

        return (new GrpcOrder())
            ->setId($output->id)
            ->setUserId($output->userId)
            ->setStatus($output->status->value)
            ->setTotal($output->total)
            ->setCreatedAt($timestamp)
            ->setItems(array_map(
                fn($item) => (new GrpcOrderItem())
                    ->setId($item['id'])
                    ->setQty($item['qty'])
                    ->setUnitPrice($item['unitPrice']),
                $output->items
            ));
    }
}
