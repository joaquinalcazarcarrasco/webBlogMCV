<?php

//Conexión con las bases de datos
function connectDB() : mysqli {

    //conexión bbdd
    $db = new mysqli($_ENV['DB__HOST'], $_ENV['DB__USER'], $_ENV['DB__PASS'], $_ENV['DB__BD']); 

    if(!$db){

        echo 'Error en la conexión con BBDD Blog';
        exit;
    }

    return $db;
}