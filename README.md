# crypto-dashboard

Тестовое задание

Проект состоит из двух частей:

- **Бэкенд** на Yii2 (REST API для работы с криптовалютами)
- **Фронтенд** на Vue.js (отображение данных с API)

---

## Требования

- PHP 8.1+
- Composer
- MySQL или другая СУБД, совместимая с Yii2
- Node.js 20.19+ (рекомендуется 22.x)
- npm или yarn

---

## Установка и запуск бэкенда (Yii2)

1. Перейдите в папку проекта Yii2 (например, `basic/`):

   ```
   cd basic/
   ```

2. Установите зависимости через Composer:

   ```
   docker-compose up -d
   docker-compose exec php bash
       composer install
   ```

3. Создайте и примените миграции для таблицы `crypto_currency`:

   ```
   php yii migrate
   ```

4. Запускайте команду для обновления данных:
    ```
   docker-compose up -d php php yii crypto/fetch
   ```

5. Запустите встроенный сервер Yii2:

   ```
   docker-compose up -d php php yii serve --port=8080
   ```

API будет доступен по адресу:
`http://localhost:8080/crypto-currency`

---

## Установка и запуск фронтенда (Vue.js)

1. Перейдите в папку фронтенда:

   ```
   cd app/
   ```

2. Установите зависимости:

   ```
   npm install
   ```

3. Запустите dev-сервер:

   ```
   npm run dev
   ```

4. Откройте в браузере:

   ```
   http://localhost:5173
   ```

## Контакты

Если возникнут вопросы или проблемы, обращайтесь в issues или по email:
<corchagin.vlad2005@yandex.ru>

---

Спасибо за проверку проекта!
