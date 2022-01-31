<?php

namespace PHPMVC\Models;

class UserModel extends AbstractModel
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $confirm_password;
    private $photo;
    private  $code;
    private $created_at;
    private $updated_at;

    public static $tableName = 'user';
    protected static $primaryKey = 'id';
    public static $tableSchema = array(
        'username'    => self::DATA_TYPE_STR,
        'email'  => self::DATA_TYPE_STR,
        'password'  => self::DATA_TYPE_STR,
        'photo' => self::DATA_TYPE_STR,
    );

    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }


    public function __get($name)
    {
        return $this->$name;
    }
    public  function setCode()
    {
        $this->code = rand(10000, 99999);
    }
    public  function getCode()
    {
        return $this->code;
    }
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    public function getPhoto()
    {
        return $this->photo;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }
     
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

    }
}
