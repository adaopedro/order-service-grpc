<?php

declare(strict_types=1);

use App\Adapter\CreateOrderController;
use App\Adapter\ListOrdersController;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::addServer("grpc", function () {
    Router::addGroup("/OrderPackage.OrderService", function () {
        Router::post("/CreateOrder", [CreateOrderController::class, "index"]);
        // Router::post("/GetOrder", [App\Controller\OrderController::class, "getOrder"]);
        // Router::post("/ListOrders", [ListOrdersController::class, "index"]);
        // Router::post("/CancelOrder", [App\Controller\OrderController::class, "cancelOrder"]);
    });
});
