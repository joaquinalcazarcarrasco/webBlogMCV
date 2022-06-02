<?php

namespace Controllers;

use MVC\Router;
use Model\News;
use Model\Users;
use Model\Comments;
use Intervention\Image\ImageManagerStatic as Image; //librería formateo imágenes

class NewsController{

    //funciones para mostrar páginas / estáticas para poder referenciarlas sin instanciar
    public static function admin(Router $router){

        //evaluar si hay login hecho
        $isLogged = isLogged();
    
        //Se comprueba si se está logado
        checkAuth();

        //contamos total de entradas
        $totalNews = News::countFromUser($_SESSION['id']);

        //comprobar varialbes en GET
        $resultGET = $_GET['result'] ?? null;
        $search = $_GET['search'] ?? null;

        //Inicializamos allnews
        $allNews = [];
        

        //Si hay búsqueda
        if($search){

            //Sacamos count de la busqueda
            $totalSearchedNews = News::countSearch($search, $_SESSION['id']);

            //machacamos
            $totalNews = $totalSearchedNews;
        }

        //Si hay resultados
        if($totalNews > 0){

            //inicializamos page a false
            $page = false;

            //Si hay info de página
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }

            //Si no hay info de página
            if(!$page){
                
                $start = 0;
                $page = 1;

            }else{

                //Se empieza por el registro de este cálculo
                $start = ($page - 1) * ITEMS_PAGE;
            }

            //Total pages
            $totalPages = ceil($totalNews / ITEMS_PAGE);


            //Sacamos todas las entradas con el limit y filtraddo user
            $allNews = News::getFromUser($_SESSION['id'], $start);
        

            //Si hubo búsqueda
            if($search){

                //Sacamos todas las entradas de esa búsqueda con el limit
                $searchedNews = News::getSearch($search, $start, $_SESSION['id']);
                $allNews = $searchedNews;

            }

        }
        
        $router->render('admin/index', [

            'isLogged' => $isLogged,
            'allNews' => $allNews,
            'totalNews' => $totalNews,
            'resultGET' => $resultGET,
            'search' => $search,
            'page' => $page ?? null,
            'totalPages' => $totalPages ?? null
            
        ]);
         
    }

    public static function crear(Router $router){

        //evaluar si hay login hecho
        $isLogged = isLogged();
        
        //Se comprueba si se está logado
        checkAuth();

        //nueva instancia vacía para rellenar de vcío la primera vez
        $news = new News();

        //Inicializamos array errores
        $errors = News::getErrors();

       // //Comprobamos si ha habido petición post
        if($_SERVER['REQUEST_METHOD']==='POST'){

            //Creamos instancia de news con los datos en POST
            $news = new News($_POST);

            //Comprobamos si se subió imagen
            if($_FILES['image']['tmp_name']){

                //para crear un hash al nombre de la imagen, se usan las 3 funciones para mayor seguridad
                $imageName = md5( uniqid( rand(), true)) . '.jpg';
                $image = Image::make($_FILES['image']['tmp_name'])->fit(800,600);

                //Guardamos la imagen en el objeto
                $news->setImage($imageName);
        
            }

            //validamos datos
            $errors = $news->validateData();

            //Si no hay errores
            if(empty($errors)){ 

                //Creo directorio si no existe
                if(!is_dir(DIR_IMAGES)) mkdir(DIR_IMAGES);
                
                //guardamos imagen
                $image->save(DIR_IMAGES . $imageName);

                //guardamos registro
                $news->save();

            }
        } 
        
        $router->render('admin/crear', [

            'news' => $news,
            'errors' => $errors,
            'isLogged' => $isLogged

        ]);
    }

    public static function actualizar(Router $router){
        
        //evaluar si hay login hecho
        $isLogged = isLogged();
        
        //Se comprueba si se está logado
        checkAuth();

        //nueva instancia vacía para rellenar de vacío la primera vez
        $news = new News();

        //Recupera el id que trae con el GET y lo valido
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        //Si no pasa validación, redirección
        if(!$id){

           header('Content-Type: text/html; charset=utf-8; Location: /admin');
          
        }else{

            //Obtenemos la entrada
            $news = News::find($id);

            //Inicializamos array errores
            $errors = News::getErrors();
        }

        //Comprobamos si ha habido petición post
        if($_SERVER['REQUEST_METHOD']==='POST'){

            
            $news->synchronise($_POST);

            //validamos datos
            $errors = $news->validateData();

            //para crear un hash al nombre de la imagen, se usan las 3 funciones para mayor seguridad
            $imageName = md5( uniqid( rand(), true)) . '.jpg';

            //Comprobamos si se subió imagen
            if($_FILES['image']['tmp_name']){
                
                $image = Image::make($_FILES['image']['tmp_name'])->fit(800,600);

                //Guardamos la imagen en el objeto
                $news->setImage($imageName);
        
            }

            

            //Si no hay errores
            if(empty($errors)){ 

                if($_FILES['image']['tmp_name']){

                    //guardamos imagen
                    $image->save(DIR_IMAGES . $imageName);
                }
                
                //guardamos registro
                $news->save();

            }
        }

        $router->render('admin/actualizar', [

            'isLogged' => $isLogged,
            'news' => $news,
            'id' => $id,
            'errors' => $errors

        ]);
    }

    public static function eliminar(){
        //Cuando se hace llamada POST
        if($_SERVER['REQUEST_METHOD']==='POST'){

            //Validamos id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $newsToDelete = News::find($id);
                $newsToDelete->erase();
            }

        }

    }


}