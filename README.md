<h1>Manual de instalacion</h1>

<h3>Requerimientos</h3>

<ul>
    <li>PHP 5.2 o mayor</li>
    <li>Mysql</li>
    <li>composer</li>
</ul>

<h3>Instalacion</h3>
<p>
    Clonar el repositorio <br>

    una vez clonado ubicarse con la terminal de su sistema operativo  en la raiz del directotio de este proyecto y ejecutar el comando <b>composer install</b> para instalar las dependencias de composer.<br>

    importar la base de datos que esta en la raiz del proyecto con el nombre de <b>bd_bluesoft_prueba.sql</b>


    crear archivo .env en la raiz del proyecto  copiar el contenido del archivo .env.example  en el nuevo archivo .env , este archivo va contener las variables de entorno de configuracion .<br>


    en  el archivo .env editar las variables de configuracion de base de datos para conectarse.<br>

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bd_bluesoft_prueba
    DB_USERNAME=root
    DB_PASSWORD=

    <br>

    ubicarse con la terminal del sistema operativo en la raiz del proyecto y ejecutar <b>php artisan key:generate</b>

</p>


