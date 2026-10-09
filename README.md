# Order Service

Microsserviço responsável por gerenciar pedidos.

## Stack

- **Framework**: Hyperf (PHP)
- **Protocolo**: gRPC
- **Banco**: MySQL
- **Cache**: Redis
- **Arquitetura**: Clean Architecture / DDD

## Protobuf

O contrato gRPC está em `proto/order.proto`.

## Rodar

```bash
docker compose up
```

Acesse em `localhost:9501` (gRPC).