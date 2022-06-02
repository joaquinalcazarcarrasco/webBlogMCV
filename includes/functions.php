<?php

//Some predefined paths

use Controllers\UsersController;

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCTIONS_URL', __DIR__ .'functions.php');
define('DIR_IMAGES', $_SERVER['DOCUMENT_ROOT'] . '/webBlogMVC/public/images/imgNews/');
define('CLASSES_URL', __DIR__ .'/../models');
define('ITEMS_PAGE', 2);//paging limit


//Alerts in differets cases managing news CRUD
function showAlert($code){

    $message = '';

    switch($code){

        case 1:
            $message = 'Entrada creada correctamente';
            break;
        case 2:
            $message = 'Entrada actualizada correctamente';
            break;
        case 3:
            $message = 'Entrada eliminada correctamente';
            break;
        default:
            $message = false;
            break;
    }

    return $message;
}

function showAlertCV($code, $entidad){

    $message = '';

    switch($code){

        case 1:
            $message = $entidad . ' creada correctamente';
            break;
        case 2:
            $message = $entidad . ' actualizada correctamente';
            break;
        case 3:
            $message = $entidad . ' eliminada correctamente';
            break;
        default:
            $message = false;
            break;
    }

    return $message;
}

//sanitising html from form
function sanitise($html){
    $sanitise = htmlspecialchars($html, ENT_NOQUOTES, "UTF-8");
    return $sanitise;
}

//Checking authentication to let the user access to the admin site
function checkAuth(){

    //Redirect if user's not logged
    if(!$_SESSION['login']){

        header('location: /blog');
    }

}

//Checking if someone's logged to lock login page.
function alreadyLogged(){
    
    
    if(!$_SESSION['login']){
        
    }else{

        header('location: /blog');
    }
}

//Checking if there is someone logged
function isLogged(){

    //starting session
    if(session_status()!==PHP_SESSION_ACTIVE) session_start();


    //Returning boolean depending on login
    if(!isset($_SESSION['login'])){

        $_SESSION['login'] = false;

        return false;

    }else if($_SESSION['login']===true){

        return true;
        
    }else{

        return false;
    }

}

//Evaluamos si se está logado y se es admin
function isAdmin(){

    //Se invoca la función para saber si está logado
    $isLogged = isLogged();

    //Si se está logado
    if($isLogged){

        //Se obtiene el valor de admin
        $admin = $_SESSION['admin'];

        //se evalua si tiene como valor 1
        if($admin==='1'){

            //Si es así, se retorna true
            return true;

        }else{

            //Si no, se retorna false
            return false;

        }

    }else{

        //si no, se retorna false
        return false;
    }

}
