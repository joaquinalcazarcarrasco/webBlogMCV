<?php

namespace Model;

class News extends Entity {

    //Static attr, table's name
    protected static $table = 'NEWS';

    //Static attr. Table's columns
    protected static $columnsDB = ['id', 'title', 'entry', 'image', 'publishDate', 'user_id'];

    //Static attr to set the path to redirect after some actions
    protected static $path = '/admin?';

    //attr
    public $id;
    public $title;
    public $entry;
    public $image;
    public $publishDate;
    public $user_id;

    public function __construct($args = []){

        //After POST, i will set some attr. If not, predefined values
        $this->id = $args['id'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->entry = $args['entry'] ?? '';
        $this->publishDate = $args['publishDate'] ?? '';
        $this->user_id = $args['user_id'] ?? null;
        $this->image = $args['image'] ?? '';
    }

    //Validating form data / required fields
    public function validateData(){

      
        if(!$this->title){
            //Error in asoc array
            self::$errors[] = 'El título es obligatorio';
        }

        if(!$this->entry){
            //Error in asoc array
            self::$errors[] = 'El contenido es obligatorio';
        }

        if(!$this->image){
            //Error in asoc array
            self::$errors[] = 'La imagen es obligatoria';
        }

        return self::$errors;

    }

    //Method -> Select to get the number of News of an specific user
    public static function countFromUser($user_id){

        $query = 'SELECT COUNT(*) as contador FROM ' . static::$table . ' WHERE user_id=' . $user_id . ';';
        
        $result = self::$db->query($query);
        $row = $result->fetch_assoc();

        return $row['contador'];

    }
    
    //Method -> Select to get all the News of an specific user
    public static function allNewsFromUser($user_id){

        $query = 'SELECT * FROM ' . static::$table . ' WHERE user_id=' . $user_id .' ORDER BY publishDate DESC;';
        $result = self::readQuery($query);

        return $result;

    }

    //Paging
    public static function getFromUser($user_id, $start){

        $query = 'SELECT * FROM ' . static::$table . ' WHERE user_id=' . $user_id .' ORDER BY publishDate DESC LIMIT ' . $start . ', ' . ITEMS_PAGE . ';';
        $result = self::readQuery($query);


        return $result;
        
    }

    //Select with a searching criteria
    public static function searchNews($search, $user_id=null){

        if($user_id){
            $query = 'SELECT * FROM ' . static::$table . ' WHERE MATCH(title) AGAINST ("' . $search .'" IN BOOLEAN MODE) AND user_id="' . $user_id .'" ORDER BY publishDate DESC;';
        }else{
            $query = 'SELECT * FROM ' . static::$table . ' WHERE MATCH(title) AGAINST ("' . $search .'" IN BOOLEAN MODE) ORDER BY publishDate DESC;';
        }
   
        $result = self::readQuery($query);

        return $result;

    }

    //Select for pagin using searching criteria
    public static function getSearch($search,$start, $user_id=null){

        if($user_id){
            $query = 'SELECT * FROM ' . static::$table . ' WHERE MATCH(title) AGAINST ("' . $search .'" IN BOOLEAN MODE) AND user_id="' . $user_id .'" LIMIT ' . $start . ', ' . ITEMS_PAGE . ';';
        }else{
            $query = 'SELECT * FROM ' . static::$table . ' WHERE MATCH(title) AGAINST ("' . $search .'" IN BOOLEAN MODE) LIMIT ' . $start . ', ' . ITEMS_PAGE . ';';
        }
        $result = self::readQuery($query);


        return $result;
        
    }

    //Getting the number of items after a search
    public static function countSearch($search, $user_id=null){

        if($user_id){
            $query = 'SELECT COUNT(*) as contador FROM ' . static::$table . ' WHERE MATCH(title) AGAINST ("' . $search .'" IN BOOLEAN MODE) AND user_id="' . $user_id .'";';
        }else{
            $query = 'SELECT COUNT(*) as contador FROM ' . static::$table . ' WHERE MATCH(title) AGAINST ("' . $search .'" IN BOOLEAN MODE);';
        }

        $result = self::$db->query($query);
        $row = $result->fetch_assoc();

        return $row['contador'];
        
    }
}