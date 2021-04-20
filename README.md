<h1>Manual de instalacion</h1>

<h3>Requerimientos</h3>

<ul>
    <li>PHP 5.2 o mayor</li>
    <li>Mysql</li>
    <li>composer</li>
</ul>

<h3>Instalacion</h3>
<ul>
    <li>Clonar el repositorio </li>
    <li>una vez clonado ubicarse con la terminal de su sistema operativo  en la raiz del directotio de este proyecto y ejecutar el comando <b>composer install</b> para instalar las dependencias de composer.</li>
    <li>importar la base de datos que esta en la raiz del proyecto con el nombre de <b>bd_bluesoft_prueba.sql</b></li>
    <li>crear archivo <b>.env</b> en la raiz del proyecto  copiar el contenido del archivo <b>.env.example</b>  en el nuevo archivo <b>.env</b> , este archivo va contener las variables de entorno de configuracion .</li>
    <li>
        en  el archivo <b>.env</b> editar las variables de configuracion de base de datos para conectarse.
        <ul>
            <li>DB_CONNECTION=mysql</li>
            <li>DB_HOST=127.0.0.1</li>
            <li>DB_PORT=3306</li>
            <li>DB_DATABASE=bd_bluesoft_prueba</li>
            <li>DB_USERNAME=root</li>
            <li>DB_PASSWORD=</li>
        </ul>
    </li>
    <li>ubicarse con la terminal del sistema operativo en la raiz del proyecto y ejecutar <b>php artisan key:generate</b></li>

</ul>

<h3>Ejecutar aplicacion</h3>

<ul>
    <li>
        abrir la terminal de comandos del sistema opertivo y ubicarse en el directorio donde esta nuestra aplicacion
        ejecutar el siguiente comando <b>php artisan serve --port=5000</b>
        la aplicacion iniciara el servidor y se ejecutara en el puerto 5000  , especialmente seleccione el puerto 5000 porque yo tenia otras aplicaciones corriendo en el puerto 8000 que es el que usa por defecto
    </li>

</ul>


<h3>Tecnologias usadas</h3>

<p>
    Para esa aplicacion use el framework laravel 7.0 para el desarrollo de las api rest que expuse para una aplicacion en angular
    mysql como motor de bases de datos para crear la base de datos a la que se conecta la aplicacion
    composer que es el manejador de dependencias de laravel
</p>

<h3>Explicacion logica de la aplicacion</h3>
<p>
    sea realizo una estructura sencilla con 4 modulos principales cada modulo es un endpoint en la aplicacion de laravel un api rest que se consume atravez de un front en angular que posee la interfaz grafica
    estos modulos son:
    <ul>
        <li>Crear cuenta que recibe dos parametros nombre y saldo incial de la cuenta esto crea un numero de cuenta unico para el usuario de 7 digios con el cual realizara el resto de operaciones</li>
        <li>Modulo consignar que simula una consignacion a la cuenta creada o a cualquier cuenta existente recibe el numero de cuenta valido y el valor a consignar el sistema devuelve a que cuenta se consigno y el nuevo saldo de la cuenta</li>
        <li>Modulo retirar al igual que el modulo de consignar recibe el numero de cuenta y un valor a retirar el sistema devuelve el numero de cuenta al cual se retiro y el nuevo saldo</li>
        <li>Luego tenemos el modulo de consultar este recibe el numero de cuenta y el sistema devuelve el valor del saldo que posee en la cuenta</li>
    </ul>
</p>
