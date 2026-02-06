# README: Тестовое задание для компании Effective Mobile


Проект представляет собой API‑сервис на Laravel с CRUD‑операциями для сущности **Task** (задача). Реализована аутентификация через **Laravel Sanctum**, написаны тесты для API‑маршрутов.

## 1. Технические требования

- PHP 8.1+
- Laravel 12
- Composer
- MySQL/PostgreSQL
- Artisan CLI
- Sanctum для аутентификации

## 2. Установка и настройка

### 2.1. Клонирование проекта
    ```bash
    git clone https://github.com/Codovod/test-task-effective-mobile
    cd mobile-effective-test
    ```

### 2.2. Установка зависимостей
    ```bash
    composer install
    ```

### 2.3. Настройка окружения
1. Создайте файл `.env` (на основе `.env.example`).
2. Настройте подключение к БД:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mobile_effective
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Сгенерируйте ключ приложения:
   ```bash
   php artisan key:generate
   ```

### 2.4. Миграции и заполнение БД
    ```bash
    php artisan migrate --seed
    ```
> *Примечание:* Сидеры создают тестового пользователя и несколько задач.


### 2.5. Запуск локального сервера
    ```bash
    php artisan serve
    ```
API будет доступно по адресу: `http://localhost:8000`


## 3. API‑маршруты (CRUD для Task)

Все маршруты защищены middleware `auth:sanctum` (требуется токен).

| Метод | URL | Описание |
|-------|-----|--------|
| `GET` | `/api/tasks` | Получить список задач |
| `POST` | `/api/tasks` | Создать новую задачу |
| `GET` | `/api/tasks/{id}` | Получить задачу по ID |
| `PUT/PATCH` | `/api/tasks/{id}` | Обновить задачу |
| `DELETE` | `/api/tasks/{id}` | Удалить задачу |

### Пример тела запроса (`POST /api/tasks`)
    ```json
    {
      "title": "Новая задача",
      "description": "Описание задачи",
      "status": "in_progress"
    }
    ```

## 4. Аутентификация (Sanctum)

### 4.1. Получение токена
**Маршрут:** `POST /api/login`  
**Тело запроса:**
    ```json
    {
      "email": "test@user.com",
      "password": "password"
    }
    ```
**Ответ:**
    ```json
    {
      "token": "1|abc123xyz..."
    }
    ```

### 4.2. Использование токена
Добавьте в заголовок запроса:
    ```
    Authorization: Bearer <ваш-токен>
    ```

## 5. Тестирование

### 5.1. Запуск тестов
    ```bash
    php artisan test
    ```
Или для конкретных тестов:
    ```bash
    php artisan test --filter TaskApiTest
    ```

### 5.2. Описанные тесты
- `TaskApiTest::test_can_get_tasks_list()` — проверка получения всех задач.
- `TaskApiTest::test_can_create_task()` — проверка создания новой задачи.
- `TaskApiTest::test_can_get_single_task()` — проверка получения задачи по ID.
- `TaskApiTest::test_can_update_task()` — обновление задачи.
- `TaskApiTest::test_can_delete_task()` — удаление задачи.
- `AuthTest::test_unauthenticated_user_cannot_access_tasks()` — проверка доступа без авторизации.


## 6. Структура проекта

```
app/
├── Models/Task.php
├── Http/Controllers/TaskController.php
└── Providers/AuthServiceProvider.php

database/
├── migrations/
└── seeds/DatabaseSeeder.php

routes/
└── api.php

tests/
├── Feature/TaskApiTest.php
└── Unit/AuthTest.php
```

## 7. Используемые пакеты и технологии

- **Laravel 12** — основной фреймворк.
- **Sanctum** — аутентификация API.
- **Faker** — генерация тестовых данных.
- **PHPUnit** — тестирование.


## 8. Дополнительные инструкции

### 8.1. Генерация документации API
Для просмотра маршрутов:
    ```bash
    php artisan route:list
    ```

### 8.2. Очистка кэша
Если возникают проблемы с конфигурацией:
    ```bash
    php artisan config:clear
    php artisan cache:clear
    ```

### 8.3. Работа с Sanctum
- Токен хранится в таблице `personal_access_tokens`.
- Для отзыва токена используйте:
    ```php
    $user->tokens()->delete();
    ```

## 9. Примечания

- Все даты возвращаются в формате ISO 8601 (`YYYY-MM-DDTHH:MM:SS.SSSSSSZ`).
- Поля `created_at` и `updated_at` автоматически заполняются Eloquent.
- Для разработки рекомендуется использовать **Postman** или **Insomnia** для тестирования API.

## 10. Контакты
По вопросам:
- Telegram: `@larionov_one`
- Email: `larionov-a@inbox.ru`
