# Lara-N

## Локальный запуск

Нужны Docker с Compose v2 и Node.js 24 с npm. Выполняй команды из корня проекта.

### Первый запуск

1. Если `.env` ещё нет, скопируй шаблон. Настройки PostgreSQL и Mailpit уже в нём.

   - PowerShell — `Copy-Item .env.example .env`
   - Linux — `cp .env.example .env`

2. Собери образ приложения. Если `APP_KEY` пустой, выполни вторую команду и вставь полученный ключ целиком в `.env`.

   ```bash
   docker compose build app
   docker compose run --rm --no-deps -T app php artisan key:generate --show --no-interaction
   ```

3. Запусти сервисы и примени миграции.

   ```bash
   docker compose up -d
   docker compose exec app php artisan migrate --no-interaction
   ```

4. Для входа в админку создай администратора со своим email и паролем.

   ```bash
   docker compose exec app php artisan orchid:admin --no-interaction "Local Admin" "admin@example.test" "replace-with-your-local-password"
   ```

5. В отдельном терминале установи зависимости фронтенда и запусти Vite.

   ```bash
   npm install --ignore-scripts
   npm run dev
   ```

### Повседневная работа

Запускай Docker через `docker compose up -d`, а Vite через `npm run dev` в отдельном терминале.

- [Приложение](http://localhost:8080)
- [Админка Orchid](http://localhost:8080/admin)
- [Тестовые письма в Mailpit](http://localhost:8025)

После изменения `.env` выполни `docker compose up -d --force-recreate app`.

Для остановки заверши Vite через `Ctrl+C` и выполни `docker compose down`.
