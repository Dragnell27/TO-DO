# TO-DO
Aplicación web para la gestión de Tareas.

## Instalación

### Requisitos
- composer v2.7.8
- PHP v8.2.*

### Pasos de instalación
1. Clona el repositorio: `git clone https://github.com/Dragnell27/TO-DO.git`.
2. Importamos la base de datos(BD) que esta en la ruta `TO-DO/database/todo.sql`.
3. En la carpeta principal `TO-DO/` ejecutamos el comando `composer install` para instalar las dependencia de composer.
4. Creamos el archivo .env clonando el .env.example con el comando: `cp .env.example .env`.
5. Generamos la key con el comando: `php artisan key:generate`.
6. Abrimos el archivo .env que se genero y modificamos la configuración de BD según nuestras necesidades.
7. Creamos la ruta para el paquete de traducción a español con el comando. `mkdir vendor/laravel/framework/src/Illuminate/Translation/lang/es`.
8. copiamos el paquete de traducción de español en la ruta creada en el paso anterior con el comando `cp -r resources/lang/es/ vendor/laravel/framework/src/Illuminate/Translation/lang/es`.
9. Corremos la aplicación con el comando `php artisan serve` y debería arrojarnos `Server running on [http://127.0.0.1:8000]` donde la url dentro de los corchetes seria donde estará alojada nuestra aplicación.
10. Por ultimo, pegamos la url del proyecto en el navegador.


