<?php

namespace Controllers;

use MVC\Router;
use Model\Users;

class UsersController{

    public static function login(Router $router){

        //credentials es true. La cabecera se modificará para mostrar unas opciones de menú específicas
        $credentials = true;
        
        //Chequear si el usuario está logado
        $isLogged = isLogged();
        alreadyLogged();

        //Se crea una instancia vacía de Users
        $user = new Users;

        //Array para almacenar errores
        $errors = Users::getErrors();

        //After POST call
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
            //New instance of Users using POST data
            $user = new Users($_POST);
            $user::$context = "login";

            //validating data
            $errors = $user->validateData();
            
        }
        
        $router->render('blog/login', [

            'credentials' => $credentials,
            'isLogged' => $isLogged,
            'user' => $user,
            'errors' => $errors
            
        ]);
         
    }

    public static function salir(){

        //Iniciando sesión
        session_start();

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';

        //Cerrando sesión
        $_SESSION = [];        

        if($url_actual==='/administrador/salir'){

            //Redirigiendo a inicio
            header('location: /');

        }else if($url_actual==='/blog/salir'){

            //Redirigiendo a inicio de blog
            header('location: /blog');
        }

    }

    public static function registro(Router $router){
        //credentials es true. Opciones de menú específicas en la cabecera
        $credentials = true;
        //Se chequea si hay usuario logado
        $isLogged = isLogged();
        alreadyLogged();

        //Si hubo algún resultado después del POST o no
        $resultGET = $_GET['result'] ?? null;

        //Nueva instancia de Users vacía
        $user = new Users;
        
        //Se crea un array de errores a través de una función estática
        $errors = Users::getErrors();

        //Si hay llamada POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Nueva instancia de Users usando $_POST
            $user = new Users($_POST);
            $user::$context = "signup";

            //Validando datos
            $errors = $user->validateData();

            //Si no hay errores
            if(empty($errors)){

                //Se inserta datos de usuario en la base de datos
                $user->save();

            }

        }

        $router->render('blog/registro',[
            'credentials' => $credentials,
            'isLogged' => $isLogged,
            'resultGET' => $resultGET,
            'user' => $user,
            'errors' => $errors
        ]);
    }

}