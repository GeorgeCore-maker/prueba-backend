# prueba-backend: Este proyecto fue construido por Jorge Armando Diaz Alarcon:

- PHP Laravel 12 con PHP 8.2; JavaScript; HTML con bootstap

# I. Instalar en un entorno local
Si deseas implementar esta aplicación en tu entorno local, sigue estos pasos:

# II. Para clonar el repositorio:
git clone prueba-backend

# digitamos en la consola:
composer install

# III. Sacamos una copia el archivo .env.example a .env y agregamos:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=dialogflow
DB_USERNAME=root
DB_PASSWORD=

# IV. Ejecutamos las migraciones y los seeders para los productos y servicios

php artisan migrate --seed

# V. y corremos el servidor:

php artisan serve

Finalmente entramos para explorar a http://127.0.0.01:8000
