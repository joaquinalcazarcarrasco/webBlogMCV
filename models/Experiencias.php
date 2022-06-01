<?php

namespace Model;

class Experiencias extends Entity {

    //Atributo estático, nombre de tabla
    protected static $table = 'experiencias';

    //array estático para almacenar las columnas de la tabla
    protected static $columnsDB = ['id', 'empresa', 'fechaInicio', 'fechaFinal', 'descripcion', 'categoria', 'clientes', 'entornos'];

    //Atributo estático para ajustar la direccion a la que redireccionar algunas acciones
    protected static $path = '/experiencias/index?';

    //Attr
    public $id;
    public $empresa;
    public $fechaInicio;
    public $fechaFinal;
    public $descripcion;
    public $categoria;
    public $clientes;
    public $entornos;

    //constructor
    public function __construct($args = []){

        //Tras llamada POST, se da valor a los atributos. Si no, valor predeterminado
        $this->id = $args['id'] ?? null;
        $this->empresa = $args['empresa'] ?? '';
        $this->fechaInicio = $args['fechaInicio'] ?? '';
        $this->fechaFinal = $args['fechaFinal'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->categoria = $args['categoria'] ?? null;
        $this->clientes = $args['clientes'] ?? '';
        $this->entornos = $args['entornos'] ?? '';
    }

   //Validación de datos // campos obligatorios
   public function validateData(){

        if(!$this->empresa){
            
            //Se añade error a array de errores
            self::$errors[] = 'La empresa es obligatoria';
        }

        if(!$this->fechaInicio){
            
            //Se añade error a array de errores
            self::$errors[] = 'La fecha de inicio es obligatoria';
        }

        if(!$this->descripcion){
            
            //Se añade error a array de errores
            self::$errors[] = 'La descripción es obligatoria';
        }

        if(!$this->categoria){
            
            //Se añade error a array de errores
            self::$errors[] = 'La categoría es obligatoria';
        }
        
        return self::$errors;

    }

    //OVERRIDE - insertar o actualizar elemento. Se devuelve si fue ok o no
    public function save(){

        //If id is null then it is a new element. If not, it would be an existing element to update
        is_null($this->id) ? $exito = $this->create() : $exito = $this->update();

        return $exito;
    
    }

    //Deleting an element
    public function erase(){

        //Query to delete an element.
        $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . ";";
        $result = self::$db->query($query);

        return $result;
    }


    //OVERRIDE - para filtrar el campo fechaFinal
    public function update(){

        //Getting an asoc array with columns and values of the element 
        $attr = $this->mapAttr();

        //si no se introdujo fechafinal, se elimina del array de atributos
        if(trim($attr['fechaFinal'])===''){

            unset($attr['fechaFinal']);

            //Se actualiza la fechaFinal a NULL
            //Se hace aparte, porque en la query final da error, no permite poner NULL
            $query = "UPDATE " . static::$table . " SET fechaFinal = NULL WHERE id ='" . self::$db->escape_string($this->id) . "' LIMIT 1;";

            $result = self::$db->query($query);

        }

        $values = [];

        //Getting the values
        foreach($attr as $key => $value){

            $values[] = "$key = '${value}'";
        
        }

        //Query to update the data of an element
        $query = "UPDATE " . static::$table . " SET ";
        $query .= join(", ", $values);
        $query .= " WHERE id ='" . self::$db->escape_string($this->id) . "' LIMIT 1;";

        //execute query
        $result = self::$db->query($query);

        return $result;

    }

    //OVERRIDE - Controlar si no se ha introducido fechaFinal
    public function create(){
        
        //Getting an asoc array with columns and values of the element 
        $attr = $this->mapAttr();

        //si no se introdujo fechafinal, se elimina del array de atributos
        if(trim($attr['fechaFinal'])===''){

            unset($attr['fechaFinal']);
        }

        //Query to insert the new element
        $query = "INSERT INTO " . static::$table . " ( ";
        //concatenamos
        $query .= join(", ", array_keys($attr));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($attr));
        $query .= "');";

        //execution of the query
        $result = self::$db->query($query);

        return $result;

    }

    //Método -> Todas las experiencias de una categoría
    public static function allExperienciasFromCategoria($categoria){

        $query = 'SELECT * FROM ' . static::$table . ' WHERE categoria = "' . $categoria .'" ORDER BY fechaInicio DESC;';
        $result = self::readQuery($query);

        return $result;

    }

    //Método para obtener último id de registro insertado
    public static function ultimoIdInsertado(){
        $query = 'SELECT MAX(id) as maxid FROM ' . static::$table . ';';
        $result = self::$db->query($query);
        $row = $result->fetch_assoc();

        return $row['maxid'];
    }
}