<?php

namespace Model;

class Users extends Entity {

    //Static attr. Table's name
    protected static $table = 'USERS';
    

    //Static attr. Table's columns
    protected static $columnsDB = ['id', 'email', 'nickname', 'password', 'admin'];

    //Static attr. Path to redirect after some actions
    protected static $path = '/blog/registro?';

    //Static attr to get the context (login or signing up)
    public static $context;

    //attr
    public $id;
    public $email;
    public $nickname;
    public $password;
    public $admin;

    public function __construct($args = []){

        //After POST, i will set some attr. If not, predefined values
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->nickname = $args['nickname'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? null;
                
    }

    //Validating form data / required fields
    public function validateData(){

        //Getting all the elements
        $resultAll = self::all(); 

        //if new user registration
        if($this::$context==='signup'){

            if(!$this->email){
               
                self::$errors[] = 'El e-mail es obligatorio';
            }else{
                
                foreach($resultAll as $user){
                    if($user->email===$this->email){
                        self::$errors[] = 'Ya existe una cuenta con ese e-mail';
                    }
                }
            }

            if(!$this->nickname){
                
                self::$errors[] = 'El nombre es obligatorio';
            }else{
                
                foreach($resultAll as $user){
                    if($user->nickname===$this->nickname){
                        self::$errors[] = 'Ya existe una cuenta con ese nombre';
                    }
                }
            }
    
            if(!$this->password){
                
                self::$errors[] = 'La contraseña es obligatoria';
            }else{
                
                if(strlen($this->password)<8){
                    self::$errors[] = 'La contraseña debe ocupar como mínimo 8 caracteres';
                }
            }

        }
        
        //If someone's signing in
        if($this::$context==='login'){

            //Escaping the data
            $nickname = mysqli_real_escape_string(self::$db, $this->nickname);
            $password = mysqli_real_escape_string(self::$db, $this->password);


            if(!$nickname){
                
                self::$errors[] = 'El nombre es obligatorio';
            }else{

                if(!$password){
                    
                    self::$errors[] = 'La contraseña es obligatoria';
                }else{

                    //Checking if the user exists
                    $query = "SELECT * FROM USERS WHERE nickname = '${nickname}';";
                    $result = mysqli_query(self::$db, $query);

                    
                    if($result->num_rows){
                        
                        
                        $user = mysqli_fetch_assoc($result); 

                        //validating password
                        $auth = password_verify($password, $user['password']);

                        //if password is correct
                        if($auth){

                        
                            //Adding user info in $_SESSION
                            $_SESSION['nickname'] = $user['nickname'];
                            $_SESSION['id'] = $user['id'];
                            $_SESSION['admin'] = $user['admin'];
                            $_SESSION['login'] = true;

                            if($_GET['from']){
                                
                                //redirect to the news
                                header('location: /blog/entrada?id=' . $_GET['id']);
                            
                            }else{
                               
                                //redirecto to admin
                                header('location: /admin');
                            }

                            

                        }else{

                            self::$errors[] = 'La contraseña es incorrecta';
                        }
                
                    }else{

                        self::$errors[] = 'El usuario no existe';
                    }
                }
            }

        }
        
        return self::$errors;

    }

    //Saving data in the database
    public function save(){

        //If everything's ok, the password will be hashed.
        if($this->password!==''){

            $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
            $this->password = $passwordHash;
        }

        //calling to create function
        self::create();
    
    }

    //obtener campo admin
    public function getAdmin($nickname, $id){

        $query = 'SELECT admin FROM ' . static::$table . ' WHERE id = ' . $id .' AND nickname = ' . $nickname .';';
        $result = self::$db->query($query);
        $row = $result->fetch_assoc();

        return $row['admin'];

    }
    
}