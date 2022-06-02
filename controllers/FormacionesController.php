<?php

namespace Controllers;

use MVC\Router;
use Model\CategoriasFormaciones;
use Model\Competencias;
use Model\CompetenciasFormaciones;
use Model\SubcategoriasFormaciones;
use Model\Formaciones;

class FormacionesController{


    //REVISAR TODOS LOS MÉTODOOS

    public static function index(Router $router){

        //Se evalua si se está logado y como admin
        $isAdmin = isAdmin();

        //Si no se es ADMIN
        if(!$isAdmin){

            //se redirecciona
            header('location: /');
        }

        //Consulta de todas las categorías
        $categorias = CategoriasFormaciones::all();
        $subcategoriasPorCategoria = [];
        $formacionesPorSubcategoria = [];
        $competenciasPorFormacion = [];

        //Recorro cada categoría
        foreach($categorias as $categoria){

            //uso id de categoría como índice pare rellenar array con subcategoria filtradas por dicho id
            $subcategoriasPorCategoria[$categoria->id] = SubcategoriasFormaciones::allFromCategoria($categoria->id);

            //Recorro cada experiencia de ese id
            foreach($subcategoriasPorCategoria[$categoria->id] as $subcategoria){

                $formacionesPorSubcategoria[$subcategoria->id] = Formaciones::allFromSubcategoria($subcategoria->id);

                foreach($formacionesPorSubcategoria[$subcategoria->id] as $formacion){
                   
                    $competenciasPorFormacion[$formacion->id] = Competencias::allFromFormacion($formacion->id);
                }

                
            }

        }

        //Compruebo si se viene de alguna acción del crud
        $registroResultado = '';
        if(isset($_GET['result'])){

            $registroResultado = showAlertCV($_GET['result'],'Formación');
        }
        
        $cv = true;

        $router->render('formaciones/index',[

            'cv' => $cv,
            'subcategoriasPorCategoria' => $subcategoriasPorCategoria,
            'formacionesPorSubcategoria' => $formacionesPorSubcategoria,
            'categorias' => $categorias,
            'competenciasPorFormacion' => $competenciasPorFormacion,
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
            header('location: /');
        }

        //plantilla cv
        $cv = true;

        //categorías
        $categorias = CategoriasFormaciones::all();
        $subcategorias = SubcategoriasFormaciones::all();

        //Recorro cada categoría
        foreach($categorias as $categoria){

            //uso id de categoría como índice pare rellenar array con subcategoria filtradas por dicho id
            $subcategoriasPorCategoria[$categoria->id] = SubcategoriasFormaciones::allFromCategoria($categoria->id);

        }

        //Instancia vacía de Experiencias
        $formacion = new Formaciones();
        $competencia = new Competencias();
        $competenciasStr = '';

        //Array de errores para campos obligaorios
        $errores = Formaciones::getErrors();

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
            $formacion = new Formaciones($_POST);

            //validamos datos
            $errores = $formacion->validateData();

            //Comprobar campo competencias
            if($_POST['competencias']===''){

                $errores[] = 'Introduce, al menos, una competencia';

            }else{

                $competenciasStr = $_POST['competencias'];
            }            

            //Si no hay errores
            if(empty($errores)){ 

                //guardamos registro de experiencia
                $exito = $formacion->save();

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
                        $idUltimaFormacion = Formaciones::ultimoIdInsertado();

                        $problemas = [];

                        //recorro las competencias de la experiencia
                        foreach($competenciasNuevasForm as $competenciaNombre){

                            //obtengo id de competencia
                            $idCompetencia = Competencias::idPorNombre($competenciaNombre);

                            //Inserto registro de competenciasExperiencias
                            $competenciaFormacion = new CompetenciasFormaciones([
                                'idFormacion' => $idUltimaFormacion,
                                'idCompetencia' => $idCompetencia

                            ]);

                            $exito = $competenciaFormacion->save();

                            if(!$exito){
                                $problemas[] = $exito;
                            }
                        }

                        if(empty($problemas)){

                            header('location: /formaciones/index?result=1');
                        }
                    }

                }

            }

        }

        $router->render('formaciones/crear',[

            'cv' => $cv,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'subcategoriasPorCategoria' => $subcategoriasPorCategoria,
            'formacion' => $formacion,
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
            header('location: /');
        }

        //para usar plantilla CV
        $cv = true;

        $hoy = date('Y-m-d');

        //inicializamos array errores
        $errores = [];

        //Creamos instancia vacía de Experiencias, categoria
        $formacion = new Formaciones();
        $categorias = CategoriasFormaciones::all();
        $subcategorias = SubcategoriasFormaciones::all();

         //Recorro cada categoría
         foreach($categorias as $categoria){

            //uso id de categoría como índice pare rellenar array con subcategoria filtradas por dicho id
            $subcategoriasPorCategoria[$categoria->id] = SubcategoriasFormaciones::allFromCategoria($categoria->id);

        }

        //Recupera el id que trae con el GET y lo valido
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        //Si no pasa validación, redirección
        if(!$id){

           header('location: /formaciones/index');
          
        }else{

            //Obtenemos la experiencia
            $formacion = Formaciones::find($id);

            //Inicializamos array errores
            $errores = Formaciones::getErrors();

            //fecha actual o no
            if($formacion->fechaFinal){

                $actual = '';
            }else{
                $actual = 'on';
            }
            
            //Consulta de las Competencias
            //Se obtienen los registro de la tabla intermedia con el id de experiencia
            $competenciasFormaciones = CompetenciasFormaciones::allPorIdFormacion($id);
            $competenciasArray = [];

            //Se recorre el array
            foreach($competenciasFormaciones as $competenciaFormacion){

                //Recupero competencia por id y lo almaceno en array
                $competencia = Competencias::find($competenciaFormacion->idCompetencia);
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
                $formacion->synchronise($_POST);
    
                //validamos datos
                $errores = $formacion->validateData();
    
                //Comprobar campo competencias
                if($_POST['competencias']===''){
    
                    $errores[] = 'Introduce, al menos, una competencia';
    
                }else{
    
                    $competenciasStr = $_POST['competencias'];
                }            
    
                //Si no hay errores
                if(empty($errores)){ 
    
                    //guardamos registro de experiencia
                    $exito = $formacion->save();
    
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
                            $borradoCompetenciasFormaciones = CompetenciasFormaciones::deletePorIdFormacion($id);
                            
                            //si se eliminaron correctamente los registros
                            if($borradoCompetenciasFormaciones){

                                //Insertar competenciasExperiencia    
                                $problemas = [];
        
                                //recorro las competencias de la experiencia
                                foreach($competenciasNuevasForm as $competenciaNombre){
        
                                    //obtengo id de competencia
                                    $idCompetencia = Competencias::idPorNombre($competenciaNombre);
        
                                    //Inserto registro de competenciasExperiencias
                                    $competenciaFormacion = new CompetenciasFormaciones([
                                        'idFormacion' => $id,
                                        'idCompetencia' => $idCompetencia
        
                                    ]);
        
                                    $exito = $competenciaFormacion->save();
        
                                    if(!$exito){
                                        $problemas[] = $exito;
                                    }
                                }
        
                                if(empty($problemas)){
        
                                    header('location: /formaciones/index?result=2');
                                }

                            }

                            
                        }
    
                    }
    
                }
    
            }

            
        }
        
        $router->render('formaciones/actualizar',[
            'cv' => $cv,
            'formacion' => $formacion,
            'errores' => $errores,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'subcategoriasPorCategoria' => $subcategoriasPorCategoria,
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
            header('location: /');
        }
        
        //Cuando se hace llamada POST
        if($_SERVER['REQUEST_METHOD']==='POST'){

            //Validamos id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){

                //Borro competenciasExperiencia
                $competenciasFormacionessBorrar = CompetenciasFormaciones::allPorIdFormacion($id);

                $problemas = [];

                foreach($competenciasFormacionessBorrar as $competencia){
                    //echo $competencia->idCompetencia . ' - ' . $competencia->idFormacion;
                    $exito = $competencia->erase();
                    
                    if(!$exito){
                        $problemas[] = $exito;
                    }

                }

                //si se han borrado todas las competenciasExperiencias
                if(empty($problemas)){

                    $formacionBorrar = Formaciones::find($id);
                    $exito = $formacionBorrar->erase();

                    if($exito){

                        header('location: /formaciones/index?result=3');
                    }
                }
            }

        }
      
    }

    
}