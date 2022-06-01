<?php

namespace MVC;

class Router{

    //array para almacenar las rutas vía GET y POST
    public $rutasGET = [];
    public $rutasPOST = [];
    
    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }

    //chequeará las rutas que se piden desde el index.php
    //también chequeará el tipo de métoto request
    public function comprobarRutas(){
        
        //$url_actual = $_SERVER['PATH_INFO'] ?? '/';//para local
        //$url_actual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];//para servidor
        $url_actual = $_SERVER['REQUEST_URI'] ?? '/';//para servidor
        
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET'){

           $fn = $this->rutasGET[$url_actual] ?? null; 

        }else{
           
            $fn = $this->rutasPOST[$url_actual] ?? null; 
        }

        if($fn){
            //Función que llama a una función dinámicamente.
            //No se conoce el nombre de la función y se pasa su nombre como variable
            call_user_func($fn, $this);
        }else{
            echo 'página no encontrada';
        }
    }

    //Función que renderiza las diferentes vistas
    //Recibe:
    //$view -> la vista a renderizar
    //$datos -> Diferentes datos que procesar -> serán variables que podemos referenciar desde las vistas
    public function render($view, $datos = []){

        //recorremos el array datos, creamos variable con valor de la clave y asignamos valor
        foreach($datos as $key => $value){
            $$key = $value;
        }

        //función que indica que vamos a empezar a guardar datos en memoria
        ob_start();
        include __DIR__ . "/views/$view.php";//doble comilla para que detecte las variables

        //Limpiamos memoria sobre el contenido que se pueda haber mostrado anteriormente
        $contenido = ob_get_clean();

        if(!isset($cv)){

            include __DIR__ . '/views/layoutBlog.php';
        
        }else{
        
            include __DIR__ . '/views/layoutCV.php';  
        
        }
        
    }
}