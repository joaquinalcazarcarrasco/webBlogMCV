<?php

namespace Model;

class Comments extends Entity {

    //Static attr, table's name
    protected static $table = 'COMMENTS';

    //Static attr to insert the columns
    protected static $columnsDB = ['id', 'comment', 'news_id', 'publishDate', 'user_id'];

    //Static attr to set the path to redirect after some actions like create the comment
    protected static $path = '/blog/entrada';

    //Attr
    public $id;
    public $comment;
    public $news_id;
    public $publishDate;
    public $user_id;

    //constructor
    public function __construct($args = []){

        //After POST, i will set some attr. If not, predefined values
        $this->id = $args['id'] ?? null;
        $this->comment = $args['comment'] ?? '';
        $this->news_id = $args['news_id'] ?? null;
        $this->publishDate = $args['publishDate'] ?? '';
        $this->user_id = $args['user_id'] ?? null;

        if($this->news_id){
            self::$path = '/blog/entrada?id=' . $this->news_id . '&';
        }
    }

    //Validating form data / required fields
    public function validateData(){

        if(!$this->comment){
            
            //Error in asoc array
            self::$errors[] = 'El comentario es obligatorio';
        }
        
        return self::$errors;

    }

    //Method -> Select to get all the comments in one specific entry
    public static function allComments($news_id){
        
        $query = 'SELECT * FROM ' . static::$table . ' WHERE news_id=' . $news_id .' ORDER BY publishDate DESC;';
        $result = self::readQuery($query);

        return $result;

    }

    //función para borrar todos los comentarios asociados a una entrada
    public static function eraseByNewsId($news_id){

        $query = 'DELETE FROM ' . static::$table . ' WHERE news_id=' . $news_id .';';
        $result = self::readQuery($query);

        return $result;

    }


    
}