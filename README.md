# Изменение настроек личного кабинета пользователя

Laravel 10, Vue3, L5-SWAGGER, TWILIO, @VerifyAssistantBot

## Requirements
- PHP v8

## Запуск

1. Установите зависимости композера: `composer install`
2. Скопируйте `.env.example` из корня в файл `.env`
3. Поднимите все контейнеры при помощи `sail up`
4. Выполните `sail artisan key:generate`  для генерации ключа приложения

## Миграции

`sail artisan migrate --seed`

## Документация API

Сгенерировать всю документацию можно при помощи команды `php artisan l5-swagger:generate`

Если проект запускается при помощи `sail`, то вместо `php` вначале нужно писать `sail` иначе модуль
не сможет правильно обратиться к транзакциям БД для генерации маршрутов документации

Вся документация к l5-swagger находится [тут](https://github.com/DarkaOnLine/L5-Swagger?tab=readme-ov-file)

После генерации документации, ее можно посмотреть по маршруту `BACKEND_URL:BACKEND_PORT/api/documentation#/`.

## Настройки смс-клиента TWILIO

Добавить в .env необходимые настройки клиента SID, TOKEN - генерируются при регистрации на сайте
TWILIO_FROM - нужна покупка номера телефона для отправки смс (пока не могу это осуществить чтобы проверить, но логика прописана)
Документация к TWILIO [тут](https://www.twilio.com/docs)

## Добавление чат-бота

В .env добавьте токен бота

Генерируем две миграции, 
`php/sail artisan vendor:publish --tag="telegraph-migrations"`
`php/sail artisan migrate`

Добавляем бота командой, `php/sail artisan new-bot`
следующие шаги можно посмотреть в документации [тут](https://docs.defstudio.it/telegraph/v1/quickstart/register-new-bot)

Добавляем вебхуки
`php/sail artisan telegraph:set-webhook {bot_id}`



