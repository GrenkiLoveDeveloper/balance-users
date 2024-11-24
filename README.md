# Тестовый проект для подсчета баланса

## Описание

Структура проекта выглядит примерно так:<br>
├── api (backend) Laravel 11<br>
├── client (frontend) vue 3<br>
├── docker<br>
└── остальные файлы докера (docker-compose, .dockerignore, aliases, Makefile)

1. Создайте по .env в api и client наподобие .env.example
2. запустите докер и запустите из корня проекта командами из Makefile

```sh
make build

make up
```

или обычными командами

```sh
docker compose --env-file ./api/.env build --no-cache
docker compose --env-file ./api/.env up -d
```
3. Для созданий пользователя из командной строки перейдите в контенейр с php и напишите например команду

```sh
php artisan user:create "Ivan" "ivan@example.com" "ivan" "12345"
```

и выполните операцию с балансом где 1 тип операции (пополнение) и 0 (списание)

```sh
php artisan balance:operate "ivan" 1 500 "Описание"
```
4. Фронт крутится на 3000 порту по умолчанию текущей сборки

