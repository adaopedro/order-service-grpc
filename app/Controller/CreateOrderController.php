<?php

declare(strict_types=1);

namespace App\Controller;

use App\Adapter\Grpc\OrderGrpcMapper;
use App\Application\UseCase\CreateOrderUseCase;
use App\Grpc\Message\CreateOrderRequest;
use App\Grpc\Message\Order;

class CreateOrderController extends AbstractController
{
    public function __construct(
        private CreateOrderUseCase $createOrderUseCase,
        private OrderGrpcMapper $mapper
    ) {}

    public function index(CreateOrderRequest $request): Order
    {

        $input = $this->mapper->createOrderGrpcToInput($request);

        $output = $this->createOrderUseCase->execute($input);

        return $this->mapper->outputToGrpcOrder($output);
    }
}
