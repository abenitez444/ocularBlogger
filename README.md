<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

Autor: Alejandro Benitez

#Instalación y despliegue de blog de LARAVEL 8 JETSTREAM + VUE + VUETIFY 

INSTRUCCIONES:

1) Clonar repositorio publico ocularBlogger | git clone https://github.com/abenitez444/ocularBlogger.git.
2) acceder a la carpeta ocularBlogger cd /var/www/ocularBlogger y ejecutamos los siguientes comandos.
3) composer update.
4) npm install && npm run watch.
5) configurar archivo .env con las credenciales de la base de datos de preferencia.
6) php artisan key:generate.
7) luego ejecutamos las migraciones y los seeder para que se creen las tablas y registros.
8) php artisan migrate --seed
9) Ejecutamos el servidor con php artisan serve.
10) Accedemos a la url localhost:8000/miblog/admin.
11) Existen 2 usuarios cargados por default.
12) Usuario: admin@gmail.com  | invitado@gmail.com constraseña: invitado2

Luego visualizar el blog a su preferencia.
