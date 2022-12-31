# GoodSurfing Backend 2.0
Goodsurfing.org

[![CI](https://github.com/voknil/gs-backend/actions/workflows/ci.yml/badge.svg)](https://github.com/voknil/gs-backend/actions/workflows/ci.yml) [![Deploy](https://github.com/voknil/gs-backend/actions/workflows/deploy.yml/badge.svg)](https://github.com/voknil/gs-backend/actions/workflows/deploy.yml)

## Local start.

```shell
$ git clone git@github.com:voknil/gs-backend.git
$ cd gs-backend
$ touch .env.local
$ docker-compose up --build -d
```

## Local minio instance support.

For unix system
```shell
$ cat '127.0.0.1 minio' >> /etc/hosts
```
