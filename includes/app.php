<?php

//document to link functionality
require __DIR__ . '/../vendor/autoload.php';//Composer autoload to import dependencies as Image intervention and my classes
//Para usar las variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');//servidor
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);//local
$dotenv->safeLoad();

require __DIR__ . '/functions.php';//functions document
require __DIR__ . '/config/database.php';//database connection

//Conexión a las bases de datos
$db = connectDB();

//SE importan clases padres
use Model\Entity;

//Se conigura la conexion a la base de datos para las clases padres y sus hijos
Entity::setDB($db);

