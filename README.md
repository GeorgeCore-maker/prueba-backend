# prueba-backend: Este proyecto fue construido por Jorge Armando Diaz Alarcon:

- PHP Laravel 12 con PHP 8.2; JavaScript; HTML con bootstap

# nota:
El sistema no permite compartir el archivo de conexion a dialogflow por lo que contiene informacion sensible, recomiendo la creación de este mediante una cuenta de google cloud con la ruta '(https://console.cloud.google.com/iam-admin/)'

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

# VI. Funcionamiento:

La interfaz esta preparada para describir el producto y cantidad escribiendo en el cuadro de busqueda 'producto'; algo parecido sucede al escribir 'categoria'.
Sí escribe una palabra como 'pan' se listaran los productos que correspondan con el nombre y tambien la categoria sumando la cantidad de productos asociados.
Para comprobar que se hizo una vinculacion con dialogflow se puede escrtibir la palabra 'hola' y la aplicación re4sponderá con un 'hola' de vuelta o un '¡Hey!', la respuesta es aleatoria pues depende de los responses creados previamente

Finalmente entramos para explorar a http://127.0.0.01:8000
