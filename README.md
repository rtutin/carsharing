Установка и запуск:

```
git clone git@github.com:rtutin/carsharing.git
composer install
cp .env.example .env
php artisan key:generate
./vendor/bin/sail up -d
./vendor/bin/sail php artisan migrate
./vendor/bin/sail php artisan db:seed
```

После будут сгенерированы таблицы для пользователей и для автомобилей, ни один автомобиль не привязан ни к одному пользователю. Приложение не развернуто в боевых условиях, а также swagger не был правильно интегрирован, потому конфиг к нему лежит в корне репозитория и swagger-ui посмотреть можно только путем копирования конфига в  https://editor.swagger.io/.

Для начала работы необходимо обратиться к методу `/api/register`, метод вернет Bearer-токен и последующие запросы слать необходимо вместе с ним.

Чтобы использовать метод `/car/change` необходимо быть пользователем с именем `admin`, данное имя - константа(хардкод). 

Для запуска тестов необходимо использовать команду `./vendor/bin/sail php artisan test`
