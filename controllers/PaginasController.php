<?php

namespace Controllers;

use MVC\Router;
use Model\News;
use Model\Users;
use Model\Comments;
use Model\Competencias;
use Model\CategoriasExperiencias;
use Model\CategoriasFormaciones;
use Model\Experiencias;
use Model\Formaciones;
use Model\SubcategoriasFormaciones;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{

    //Funciones para BLOG
    public static function blog(Router $router){

        //Chequeando que el usuario esté logado
        $isLogged = isLogged();
            
        //Se cuenta el total de entradas
        $totalNews = News::count();

        //Obteniendo el criterio de búsqueda
        $search = $_GET['search'] ?? null;

        //Instance of array
        $allNews = [];

        //if search is defined
        if($search){

            //Number of elements
            $totalSearchedNews = News::countSearch($search);

            //overwritting the news array
            $totalNews = $totalSearchedNews;
            
        }

        //In case there is at least one element after the search
        if($totalNews > 0){

            $page = false;

            //Checking if there is a page in the url
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }

            //Checking if it is the first page
            if(!$page){
                
                $start = 0;
                $page = 1;

            }else{

                //If not, page - 1
                $start = ($page - 1) * ITEMS_PAGE;
            }

            //Total number of pages
            $totalPages = ceil($totalNews / ITEMS_PAGE);


            //All news using the starting element
            $allNews = News::get($start);

            //In case of a search
            if($search){

                //All the news from the start element and fitting the criteria
                $searchedNews = News::getSearch($search, $start);
                $allNews = $searchedNews;

            }

        }

        $router->render('blog/index',[
            'totalNews' => $totalNews,
            'search' => $search,
            'allNews' => $allNews,
            'page' => $page ?? null,
            'totalPages' => $totalPages ?? null,
            'isLogged' => $isLogged

        ]);
    }

    public static function entrada(Router $router){

        //Chequeando que el usuario esté logado
        $isLogged = isLogged();

        //Se obtiene id de entrada
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);//Se valida id

        //Si había algún resultado
        $resultGET = $_GET['result'] ?? null;

        //Si el id es inválido
        if(!$id){

            //Se redirige al inicio del blog
            header('location: /');
        }

        //Se obtiene la entrada por su id
        $news = News::find($id);

        //Obteniendo autor/a de la entrada
        $user = Users::find($news->user_id);

        //Obteniendo los comentarios de la entrada
        $comments = Comments::allComments($news->id);

        //errores
        $errors = Comments::getErrors();

        //Si se envía un comentario
        if($_SERVER['REQUEST_METHOD']==='POST'){

            //Nueva instncia de Comments usando datos enviados vía POST
            $comment = new Comments($_POST);

            //Chequeando para ver si hay errores
            $errors = $comment->validateData();

            //Si todo está ok
            if(empty($errors)){

                //Se inserta el comentario en la bbdd
                $comment->save();
            }

        }

        $router->render('blog/entrada',[
            'isLogged' => $isLogged,
            'resultGET' => $resultGET,
            'news' => $news,
            'user' => $user,
            'comments' => $comments,
            'errors' => $errors,
            'id' => $id
        ]);

    }

    //Funciones para CV
    public static function index(Router $router){

        $cv = true;
        
        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        $router->render('cv/index',[
            'cv' => $cv,
            'isAdmin' => $isAdmin
        ]);
    }

    public static function sobremi(Router $router){

        $cv = true;
        
        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        $router->render('cv/sobre-mi',[
            'cv' => $cv,
            'isAdmin' => $isAdmin
        ]);
    }

    public static function contacto(Router $router){

        //para usar plantilla CV
        $cv = true;

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();
        
        //array de errores de formulario
        $errores = [];

        //array contacto vacío
        $contacto = [];
        $contacto['nombre'] = '';
        $contacto['email'] = '';
        $contacto['asunto'] = '';
        $contacto['mensaje'] = '';
        
        //Inicializamos resultado y evaluamos si hemos recibido valor para este
        $resultado = null;
        $mensajeResultado = '';
        if(isset($_GET['result'])){

            $resultado = $_GET['result'];
        }

        if($resultado==='1') $mensajeResultado = 'El mensaje ha sido enviado correctamente';
        elseif($resultado==='0') $errores[] = 'No se pudo enviar el mensaje';     

        if($_SERVER['REQUEST_METHOD']=='POST'){

            //Obtenemos array con los datos del contacto
            $contacto = $_POST['contacto'];

            if($contacto['nombre']===''){
                $errores[] = 'El nombre es obligatorio';
            }

            if($contacto['email']===''){
                $errores[] = 'El e-mail es obligatorio';
            }

            if($contacto['asunto']===''){
                $errores[] = 'El asunto es obligatorio';
            }

            if($contacto['mensaje']===''){
                $errores[] = 'El mensaje es obligatorio';
            }

            if(empty($errores)){

                //Se crea una instancia de PHPMailer
                $email = new PHPMailer();

                //Se configura SMTP
                $email->isSMTP();//se indica que se usa este protocolo
                $email->Host = 'smtp.mailtrap.io';
                $email->SMTPAuth = true;//indicamos que se debe autenticar
                $email->Username = '78d96e0950237a';//usuario
                $email->Password = 'c9c3c356a2c627';//contraseña
                $email->SMTPSecure = 'tls';//protocolo de seguridad
                $email->Port = 2525;//Puerto al que se conectará

                //Ajustar el contenido del email
                $nombreContacto = $contacto['nombre'];
                $email->setFrom('contacto@joaquinalcazarcarrasco.com', $nombreContacto);
                $email->addAddress('joaquinalcazarcarrasco@gmail.com', 'www.joaquinalcazarcarrasco.com');
                $email->Subject = $contacto['asunto'];

                //Habilitar HTML
                $email->isHTML(true);
                $email->CharSet = 'UTF-8';

                //Contenido
                $contenido = '<html><h3>';
                $contenido .= $nombreContacto . ' dice:</h4>';
                $contenido .= '<p>' . $contacto['mensaje'] . '</p>';
                $contenido .= '<p><a href="mailto:' . $contacto['email'] . '">Contestar a ' . $contacto['email']; 
                $contenido .= '</a></p></html>';
                $email->Body = $contenido;
                $email->AltBody = $contenido;

                //Enviar email
                if($email->send()){
                    
                    header('location: /contacto?result=1');

                }else{

                    header('location: /contacto?result=0');
                }

            }

            
        }

        $router->render('cv/contacto',[
            'cv' => $cv,
            'errores' => $errores,
            'mensajeResultado' => $mensajeResultado,
            'contacto' => $contacto,
            'isAdmin' => $isAdmin
        ]);
    }

    public static function experiencia(Router $router){

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Consulta de todas las categorías
        $categorias = CategoriasExperiencias::all();
        $experienciasPorCategoria = [];
        $competencias = [];

        //Recorro cada categoría
        foreach($categorias as $categoria){

            //uso id de categoría como índice pare rellenar array con experiencias filtradas por dicho id
            $experienciasPorCategoria[$categoria->id] = Experiencias::allExperienciasFromCategoria($categoria->id);

            //Recorro cada experiencia de ese id
            foreach($experienciasPorCategoria[$categoria->id] as $experiencia){

                $competencias[$experiencia->id] = Competencias::allCompentenciasFromExperiencia($experiencia->id);

            }

        }
        
        $cv = true;

        $router->render('cv/experiencia',[

            'cv' => $cv,
            'experienciasPorCategoria' => $experienciasPorCategoria,
            'categorias' => $categorias,
            'competencias' => $competencias,
            'isAdmin' => $isAdmin

        ]);

    }

    public static function formacion(Router $router){

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Consulta de todas las categorías
        $categorias = CategoriasFormaciones::all();
        $subcategoriasPorCategoria = [];
        $formacionesPorSubcategoria = [];
        $competenciasPorSubcategoria = [];

        //Recorro cada categoría
        foreach($categorias as $categoria){

            //uso id de categoría como índice pare rellenar array con subcategoria filtradas por dicho id
            $subcategoriasPorCategoria[$categoria->id] = SubcategoriasFormaciones::allFromCategoria($categoria->id);

            //Recorro cada experiencia de ese id
            foreach($subcategoriasPorCategoria[$categoria->id] as $subcategoria){

                $formacionesPorSubcategoria[$subcategoria->id] = Formaciones::allFromSubcategoria($subcategoria->id);

                $competenciasPorSubcategoria[$subcategoria->id] = Competencias::allFromSubcategoria($subcategoria->id);
            }

        }

        //Compruebo si se viene de alguna acción del crud
        $registroResultado = '';
        if(isset($_GET['result'])){

            $registroResultado = showAlertCV($_GET['result'],'Experiencia');
        }
        
        $cv = true;

        $router->render('cv/formacion',[

            'cv' => $cv,
            'subcategoriasPorCategoria' => $subcategoriasPorCategoria,
            'formacionesPorSubcategoria' => $formacionesPorSubcategoria,
            'categorias' => $categorias,
            'competenciasPorSubcategoria' => $competenciasPorSubcategoria,
            'registroResultado' => $registroResultado,
            'isAdmin' => $isAdmin

        ]);
    }

    public static function admin(Router $router){

        $cv = true;

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Si no se es ADMIN
        if(!$isAdmin){

            //se redirecciona
            header('location: /');
        }
        

        $router->render('cv/admin', [
            'cv' => $cv,
            'isAdmin' => $isAdmin
        ]);

    }
    
}