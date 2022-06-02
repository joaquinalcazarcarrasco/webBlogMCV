<?php

namespace Model;

class Entity{

    //Static attr. DB connection
    protected static $db;

    //Static attr. Table's columns
    protected static $columnsDB = [];

    //Static attr, table's name
    protected static $table = '';

    //Static attr to set the path to redirect after some actions
    protected static $path = '';

    //static attr to add form errors
    protected static $errors = [];

    //Method -> Setting the database
    public static function setDB($database){

        //Call to a method in order to get the db connection
        self::$db = $database;

    }
    
    //empty default constructor
    public function __construct($args = []){

    }

    //Saving the image for a news
    public function setImage($image){


        if(!is_null($this->id)){
            
            $this->eraseImage();
        }

        if($image){
            $this->image = $image;
        }
    }


    //Erasing an image
    protected function eraseImage(){

        $exists = file_exists(DIR_IMAGES . $this->image);
            if($exists){
                 unlink(DIR_IMAGES . $this->image);
            }
    }

    //Form errors array
    public static function getErrors(){
        return static::$errors;
    }

    //Validating data form
    public function validateData(){
 
        static::$errors = [];
        return static::$errors;

    }


    //Inserting or updating an element
    public function save(){

        //If id is null then it is a new element. If not, it would be an existing element to update
        is_null($this->id) ? $this->create() : $this->update();
    
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

        //if everything's ok
        if($result){
           
            //Redirect with a GET parameter (update ok)
            header('Content-Type: text/html; charset=utf-8; Location:' . static::$path .'result=2');
           
            
        }

    }


    //Insert a new element
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

        if($result){

            //Redirecting passing GET parameter (insert ok)
            header('Content-Type: text/html; charset=utf-8; Location:' . static::$path . 'result=1');
            
        }

    }

    //Deleting an element
    public function erase(){

        //Query to delete an element.
        $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . ";";
        $result = self::$db->query($query);

        //Erase and redirect (message: erase ok)
        if($result){
            $this->eraseImage();
            header('Content-Type: text/html; charset=utf-8; Location:' . static::$path .'result=3');
        }
    }

    //Atrr maping
    public function mapAttr(){

        //asoc array
        $attr = [];

        //Columns array iteration
        foreach(static::$columnsDB as $column){

            //Column id and publishDate will be avoid since they will be set automatically
            if($column==='id' || $column==='publishDate') continue;
            //Setting the array with column name and its value
            $attr[$column] = $this->$column;
        }

        //Sanitising to avoid query inyections
        $sanitise = $this->sanitise($attr);

        //returning the array
        return $sanitise;

    }

    //Sanitising the data recieved through forms
    public function sanitise($attr){

        $sanitise = [];
        
        //Array iteration using key to escape the value
        foreach($attr as $key => $value){

            //Sanitizamos con el método de objeto mysqli
            $sanitise[$key] = self::$db->escape_string($value);
        }

        return $sanitise;

    }

    //Function to obtain all the elements in a table. It could be ordered by date
    public static function all($orderby=false){

        if($orderby){
        
            $query = 'SELECT * FROM ' . static::$table . ' ORDER BY publishDate DESC;';
        
        }else{
        
            $query = 'SELECT * FROM ' . static::$table . ';';
        
        }
        
        $result = self::readQuery($query);


        return $result;
        
    }

    //Method to obtain the number of elements in a table
    public static function count(){
        
        $query = 'SELECT COUNT(*) as contador FROM ' . static::$table . ';';
        $result = self::$db->query($query);
        $row = $result->fetch_assoc();

        return $row['contador'];
        
    }


    //Function to obtain the elements with limit conditions and with an specific start. Paging
    public static function get($start){

        $query = 'SELECT * FROM ' . static::$table . " ORDER BY publishDate DESC LIMIT " . $start . ', ' . ITEMS_PAGE . ';';
        $result = self::readQuery($query);


        return $result;
        
    }

    //Method to get one element by its id
    public static function find($id){

        $query = "SELECT * FROM " . static::$table . " WHERE id = ${id};";
        $result = self::readQuery($query);


        //array_shift push the first element in the array
        return array_shift($result);
    }

    //Function to use dynamic queries
    public static function readQuery($query){
        
        $result = self::$db->query($query);

        
        $array = [];
        while($row = $result->fetch_assoc()){
 
            $array[] = static::createObject($row);

        }
    
        //Important in order to free memory
        $result->free();

        
        return $array;
    }

    //Converting asoc array in object of a type (News, Comments...)
    protected static function createObject($row){

        //Empty generic object
        $object = new static;

        //Filling the object with array data
        foreach($row as $key => $value){
            if(property_exists($object, $key)){
                $object->$key = $value;
            }
        }

        return $object;
    
    }


    //synchronising an element
    public function synchronise($args = []){

        foreach($args as $key => $value){
            
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }

        }

    }
}
