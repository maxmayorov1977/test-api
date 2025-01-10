
# test-api

Для работы с api выполнить:
composer install
sail up -d
sail artisan migrate
sail artisan app:seeder
указать ключ доступа к api в .env, передавать этот ключ в каждом запросе в api, в заголовке: Authorization
документация по адресу: http://localhost/swagger
если документация не доступна, попробовать выполнить sail artisan swagger-ui:install

