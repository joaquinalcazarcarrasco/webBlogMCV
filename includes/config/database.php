<?php

//Conexión con las bases de datos
function connectDB() : mysqli {

    //conexión bbdd
    $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_BD']); 

    if(!$db){

        echo 'Error en la conexión con BBDD Blog';
        exit;
    }

    return $db;
}