<?php

namespace Controllers;

use MVC\Router;
use Model\CategoriasExperiencias;
use Model\Competencias;
use Model\CompetenciasExperiencias;
use Model\Experiencias;

class ExperienciasController{

    public static function index(Router $router){

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Si no se es ADMIN
        if(!$isAdmin){

            //se redirecciona
            header('Content-Type: text/html; charset=utf-8; Location: /');
        }

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

        //Compruebo si se viene de alguna acción del crud
        $registroResultado = '';
        if(isset($_GET['result'])){

            $registroResultado = showAlertCV($_GET['result'],'Experiencia');
        }
        
        $cv = true;

        $router->render('experiencias/index',[

            'cv' => $cv,
            'experienciasPorCategoria' => $experienciasPorCategoria,
            'categorias' => $categorias,
            'competencias' => $competencias,
            'registroResultado' => $registroResultado,
            'isAdmin' => $isAdmin

        ]);
    }

    public static function crear(Router $router){

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Si no se es ADMIN
        if(!$isAdmin){

            //se redirecciona
            header('Content-Type: text/html; charset=utf-8; Location: /');
        }

        //plantilla cv
        $cv = true;

        //categorías
        $categorias = CategoriasExperiencias::all();

        //Instancia vacía de Experiencias
        $experiencia = new Experiencias();
        $competencia = new Competencias();
        $competenciasStr = '';

        //Array de errores para campos obligaorios
        $errores = Experiencias::getErrors();

        $hoy = date('Y-m-d');
        $actual = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Para campo trabajo actual
            if(!isset($_POST['actual'])){
            
                $actual = '';

            }else{
                
                $actual = $_POST['actual'];
            
            }

            //Creamos instancia de Experiencias con los datos en POST
            $experiencia = new Experiencias($_POST);

            //validamos datos
            $errores = $experiencia->validateData();

            //Comprobar campo competencias
            if($_POST['competencias']===''){

                $errores[] = 'Introduce, al menos, una competencia';

            }else{

                $competenciasStr = $_POST['competencias'];
            }            

            //Si no hay errores
            if(empty($errores)){ 

                //guardamos registro de experiencia
                $exito = $experiencia->save();

                if($exito){

                    //Pasamos las competencias a un array y descartamos las repetidas
                    //$competenciasNuevasForm = array_unique(array_map('ucwords',array_map('strtolower',array_map('trim',explode(',', $competenciasStr)))));
                    $competenciasNuevasForm = array_unique(array_map('trim',explode(',', $competenciasStr)));

                    //Comprobar que no hay competencias repetidas con la bbdd
                    $competenciasActuales = Competencias::all();
                    $competenciasActualesStr = [];
                    foreach($competenciasActuales as $competenciaActual){

                        $competenciasActualesStr[] = $competenciaActual->nombre;
                    }
                    $competenciasNuevasBBDD = array_diff($competenciasNuevasForm, $competenciasActualesStr);

                    //Insertar competencias en bbdd
                    foreach($competenciasNuevasBBDD as $competenciaNueva){

                        $competencia = new Competencias(['nombre' => $competenciaNueva]);
                        $exito = $competencia->save();

                        if(!$exito){
                            $noexitos[] = $exito;
                        }
                    }
                    
                    if(empty($noexitos)){
                        //Insertar competenciasExperiencia
                        //obtenemos último id de experiencia insertado
                        $idUltimaExperiencia = Experiencias::ultimoIdInsertado();

                        $problemas = [];

                        //recorro las competencias de la experiencia
                        foreach($competenciasNuevasForm as $competenciaNombre){

                            //obtengo id de competencia
                            $idCompetencia = Competencias::idPorNombre($competenciaNombre);

                            //Inserto registro de competenciasExperiencias
                            $competenciaExperiencia = new CompetenciasExperiencias([
                                'idExperiencia' => $idUltimaExperiencia,
                                'idCompetencia' => $idCompetencia

                            ]);

                            $exito = $competenciaExperiencia->save();

                            if(!$exito){
                                $problemas[] = $exito;
                            }
                        }

                        if(empty($problemas)){

                            header('Content-Type: text/html; charset=utf-8; Location: /experiencias/index?result=1');
                        }
                    }

                }

            }

        }

        $router->render('experiencias/crear',[

            'cv' => $cv,
            'categorias' => $categorias,
            'experiencia' => $experiencia,
            'errores' => $errores,
            'hoy' => $hoy,
            'actual' => $actual,
            'competenciasStr' => $competenciasStr,
            'isAdmin' => $isAdmin

        ]);
    }

    public static function actualizar(Router $router){

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Si no se es ADMIN
        if(!$isAdmin){

            //se redirecciona
            header('Content-Type: text/html; charset=utf-8; Location: /');
        }

        //para usar plantilla CV
        $cv = true;

        $hoy = date('Y-m-d');

        //inicializamos array errores
        $errores = [];

        //Creamos instancia vacía de Experiencias, categoria
        $experiencia = new Experiencias();
        $categorias = CategoriasExperiencias::all();

        //Recupera el id que trae con el GET y lo valido
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        //Si no pasa validación, redirección
        if(!$id){

           header('Content-Type: text/html; charset=utf-8; location: /experiencias/index');
          
        }else{

            //Obtenemos la experiencia
            $experiencia = Experiencias::find($id);

            //Inicializamos array errores
            $errores = Experiencias::getErrors();

            //fecha actual o no
            if($experiencia->fechaFinal){

                $actual = '';
            }else{
                $actual = 'on';
            }
            
            //Consulta de las Competencias
            //Se obtienen los registro de la tabla intermedia con el id de experiencia
            $competenciasExperiencias = CompetenciasExperiencias::allPorIdExperiencia($id);
            $competenciasArray = [];

            //Se recorre el array
            foreach($competenciasExperiencias as $competenciaExperiencia){

                //Recupero competencia por id y lo almaceno en array
                $competencia = Competencias::find($competenciaExperiencia->idCompetencia);
                $competenciasArray[] = $competencia->nombre;
            }

            //Se crea cadena de texto a partir de array
            $competenciasStr = join(', ', $competenciasArray);


            //Si se recibe llamada POST para actualizar datos
            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                //Para campo trabajo actual
                if(!isset($_POST['actual'])){

                    $actual = '';
    
                }else{

                    $actual = $_POST['actual'];
                    $_POST['fechaFinal'] = '';
                
                }
    
                //Creamos instancia de Experiencias con los datos en POST
                $experiencia->synchronise($_POST);
    
                //validamos datos
                $errores = $experiencia->validateData();
    
                //Comprobar campo competencias
                if($_POST['competencias']===''){
    
                    $errores[] = 'Introduce, al menos, una competencia';
    
                }else{
    
                    $competenciasStr = $_POST['competencias'];
                }            
    
                //Si no hay errores
                if(empty($errores)){ 
    
                    //guardamos registro de experiencia
                    $exito = $experiencia->save();
    
                    if($exito){
    
                        //Pasamos las competencias a un array y descartamos las repetidas
                        //$competenciasNuevasForm = array_unique(array_map('ucwords',array_map('strtolower',array_map('trim',explode(',', $competenciasStr)))));
                        $competenciasNuevasForm = array_unique(array_map('trim',explode(',', $competenciasStr)));
    
                        //Comprobar que no hay competencias repetidas con la bbdd
                        $competenciasActuales = Competencias::all();
                        $competenciasActualesStr = [];
                        foreach($competenciasActuales as $competenciaActual){
    
                            $competenciasActualesStr[] = $competenciaActual->nombre;
                        }
                        $competenciasNuevasBBDD = array_diff($competenciasNuevasForm, $competenciasActualesStr);
    
                        //Insertar competencias en bbdd
                        foreach($competenciasNuevasBBDD as $competenciaNueva){
    
                            $competencia = new Competencias(['nombre' => $competenciaNueva]);
                            $exito = $competencia->save();
    
                            if(!$exito){
                                $noexitos[] = $exito;
                            }
                        }
                        
                        if(empty($noexitos)){
                            //Se borran todas las competenciasExperiencias de esta experiencia
                            $borradoCompetenciasExperiencias = CompetenciasExperiencias::deletePorIdExperiencia($id);
                            
                            //si se eliminaron correctamente los registros
                            if($borradoCompetenciasExperiencias){

                                //Insertar competenciasExperiencia    
                                $problemas = [];
        
                                //recorro las competencias de la experiencia
                                foreach($competenciasNuevasForm as $competenciaNombre){
        
                                    //obtengo id de competencia
                                    $idCompetencia = Competencias::idPorNombre($competenciaNombre);
        
                                    //Inserto registro de competenciasExperiencias
                                    $competenciaExperiencia = new CompetenciasExperiencias([
                                        'idExperiencia' => $id,
                                        'idCompetencia' => $idCompetencia
        
                                    ]);
        
                                    $exito = $competenciaExperiencia->save();
        
                                    if(!$exito){
                                        $problemas[] = $exito;
                                    }
                                }
        
                                if(empty($problemas)){
        
                                    header('Content-Type: text/html; charset=utf-8; Location: /experiencias/index?result=2');
                                }

                            }

                            
                        }
    
                    }
    
                }
    
            }

            
        }
        
        $router->render('experiencias/actualizar',[
            'cv' => $cv,
            'experiencia' => $experiencia,
            'errores' => $errores,
            'categorias' => $categorias,
            'actual' => $actual,
            'competenciasStr' => $competenciasStr,
            'hoy' => $hoy,
            'isAdmin' => $isAdmin

        ]);
    }

    public static function eliminar(){

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Si no se es ADMIN
        if(!$isAdmin){

            //se redirecciona
            header('Content-Type: text/html; charset=utf-8; Location: /');
        }

        //Cuando se hace llamada POST
        if($_SERVER['REQUEST_METHOD']==='POST'){

            //Validamos id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){

                //Borro competenciasExperiencia
                $competenciasExperienciasBorrar = CompetenciasExperiencias::allPorIdExperiencia($id);

                $problemas = [];

                foreach($competenciasExperienciasBorrar as $competencia){
                    //echo $competencia->idCompetencia . ' - ' . $competencia->idExperiencia;
                    $exito = $competencia->erase();
                    
                    if(!$exito){
                        $problemas[] = $exito;
                    }

                }

                //si se han borrado todas las competenciasExperiencias
                if(empty($problemas)){

                    $experienciaBorrar = Experiencias::find($id);
                    $exito = $experienciaBorrar->erase();

                    if($exito){

                        header('Content-Type: text/html; charset=utf-8; Location: /experiencias/index?result=3');
                    }
                }
            }

        }
        
      
    }

    
}