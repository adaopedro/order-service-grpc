<?php

declare(strict_types=1);

namespace App\Controller;

use App\Grpc\Message\ListOrdersRequest;
use App\Grpc\Message\ListOrdersResponse;

class ListOrdersController extends AbstractController
{
    public function __construct() {}

    public function index(ListOrdersRequest $request) {}
}
