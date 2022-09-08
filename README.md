# GoodSurfing Backend 2.0
Goodsurfing.org

## Локальный запуск.
Поддерживается работа исключительно с докером. Другие способы запуска — на свой страх и риск.

#### 1. Клонируем проект и создаем `.env` из шаблона:

```shell
$ git clone git@github.com:voknil/gs-backend.git
$ cd gs-backend
```

#### 2. Записываем "127.0.0.1 ahml.local" в /etc/hosts

```shell
$ sudo echo "127.0.0.1 gs.local" >> /etc/hosts
```
в Windows, редактируем C:\Windows\System32\drivers\etc\hosts

#### 3. Устанавливаем composer зависимости

```shell
$ docker-compose run web composer install
```

#### 4. Настраиваем базу

```shell
$ make migration      
```

#### 5. Запускаем контейнеры

```shell
$ docker-compose up --build -d
```

#### 6. Проверяем работоспособность

```shell
$ curl -X 'POST' \
  'http://localhost/api/v2/ping' \
  -H 'accept: application/json' \
  -d ''
```
В ответе должен быть "pong". Приложение работает.


## Полезные команды

Проверка юнит тестов
```shell
$ make phpunit
```
Чистка кеша
```shell
$ make cache-clear
```
\
Создание пустой миграции
```shell
$ make migration-generate
```
\
Создание новой миграции на основе разницы между моделями доктрины и БД
```shell
$ migration-diff
```
\
Применение новых миграций
```shell
$ make migration
```
\
Найти роут по части URL
```shell
$ docker-compose exec web bin/console debug:router | grep 'api/v2/users...'
```