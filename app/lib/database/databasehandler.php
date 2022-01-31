<?php
namespace PHPMVC\LIB\Database;
 class DatabaseHandler{
    private static $db;
    public function __construct(){
        $this->init();
    }
    public function init(){
        try{
            self::$db = new \PDO(
                "mysql:host=" .DATABASE_HOST_NAME . ";dbname=" .DATABASE_NAME,
                DATABASE_USER_NAME,
                DATABASE_PASSWORD,
                array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }
    public static function instance(){
        if(!self::$db){
            new DatabaseHandler();
        }
        return self::$db;
    }
    public static function close()
    {
        self::$db = null;
    }


}