<?php

declare(strict_types=1);

use App\Adapter\OrderGrpcMapper;
use App\Adapter\Persistence\OrderRepository;
use App\Application\UseCase\CreateOrderUseCase;
use App\Domain\Repository\OrderRepositoryInterface;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    OrderRepositoryInterface::class => OrderRepository::class,
    CreateOrderUseCase::class => CreateOrderUseCase::class,
    OrderGrpcMapper::class => OrderGrpcMapper::class,
];
