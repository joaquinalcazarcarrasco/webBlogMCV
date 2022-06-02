<?php

namespace Model;

class CategoriasExperiencias extends Entity {

    //Atributo estático, nombre de tabla
    protected static $table = 'categoriasExperiencias';

    //array estático para almacenar las columnas de la tabla
    protected static $columnsDB = ['id', 'nombre'];

    //Attr
    public $id;
    public $nombre;

    //constructor
    public function __construct($args = []){

        //Tras llamada POST, se da valor a los atributos. Si no, valor predeterminado
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    //OVERRIDE - insertar o actualizar elemento. Se devuelve si fue ok o no
    public function save(){

        //If id is null then it is a new element. If not, it would be an existing element to update
        is_null($this->id) ? $exito = $this->create() : $exito = $this->update();

        return $exito;
    
    }

    //Updating the database 
    public function update(){

        //Getting an asoc array with columns and values of the element 
        $attr = $this->mapAttr();

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

    //OVERRIDE - para quitar la redirección. Hay que realizar otras operaciones en la bbdd y se hará la redireccion desde el controlador
    public function create(){
        
        //Getting an asoc array with columns and values of the element 
        $attr = $this->mapAttr();

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

    //Deleting an element
    public function erase(){

        //Query to delete an element.
        $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . ";";
        $result = self::$db->query($query);

        return $result;
    }

}