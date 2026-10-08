<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::addServer("grpc", function () {
    Router::addGroup("/OrderPackage.OrderService", function () {
        Router::post("/CreateOrder", [App\Controller\CreateOrderController::class, "index"]);
        // Router::post("/GetOrder", [App\Controller\OrderController::class, "getOrder"]);
        Router::post("/ListOrders", [App\Controller\ListOrdersController::class, "index"]);
        // Router::post("/CancelOrder", [App\Controller\OrderController::class, "cancelOrder"]);
    });
});
