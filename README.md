# Laravel Inicial v5.0

1. Desde el directorio del proyecto ejecutar en consola: composer install
2. Renombrar el archivo .env.example a solo .env
3. Desde el directorio del proyecto ejecutar en consola: php artisan key:generate
4. Actualizar las variables DB_DATABASE, DB_USERNAME, DB_PASSWORD en el archivo .env
5. Desde el directorio del proyecto ejecutar en consola: php artisan migrate:fresh --seed
