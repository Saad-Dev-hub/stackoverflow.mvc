<?php
namespace PHPMVC\Models;
use PHPMVC\LIB\Database\DatabaseHandler;

class AbstractModel extends DatabaseHandler
{
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_DATE = \PDO::PARAM_STR;
    const DATA_TYPE_DECIMAL = 4;

    private function prepareValues($stmt){
        foreach(static::$tableSchema as $columnName => $type){
            if($type==4){
                $modifiedValue=filter_var($this->$columnName, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$columnName}", $modifiedValue);
            }else
            $stmt->bindValue(":{$columnName}", $this->$columnName,$type);
        }
       
    }
    private static function buildParamsSQL(){
        $params ='';
            foreach(static::$tableSchema as $columnName => $type){
              $params.= $columnName . '= :' . $columnName . ',';
            }
            return rtrim($params,',');
    }
    public function create(){
        $params = $this->buildParamsSQL();
        $sql = "INSERT INTO " . static::$tableName . " SET " . self::buildParamsSQL();
        $stmt = DatabaseHandler::instance()->prepare($sql);
        $this->prepareValues($stmt);
        if($stmt->execute()){
              return true;
        }
        return false;

    }
    public function update(){
        
        $sql = "UPDATE " . static::$tableName . " SET " . self::buildParamsSQL() . ' WHERE '. static::$primaryKey .' = '.$this->{static::$primaryKey};
        $stmt = DatabaseHandler::instance()->prepare($sql);
        $this->prepareValues($stmt);
         return $stmt->execute();

    }
    public function save(){

        return $this->{static::$primaryKey} ? $this->update() : $this->create();
    }
    public static function getAll()
    {
        $sql = "SELECT * FROM ".static::$tableName;
        $stmt =DatabaseHandler::instance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        return ($result);
    }
    public static function getByPk($id)
    {
        $sql = "SELECT * FROM ".static::$tableName. " WHERE " . static::$primaryKey . " = " . $id;
        $stmt = DatabaseHandler::instance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
       $obj=array_shift($result);
        return ($obj);
    }
    public function delete(){
        $sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = " . $this->{static::$primaryKey};
        $stmt = DatabaseHandler::instance()->prepare($sql);
        return $stmt->execute();
        
    }
    // make function that take any query and return array of objects
    public static function getByQuery($sql, $params = [])
    {
        $stmt = DatabaseHandler::instance()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        return ($result);
    }
    public static function getByEmail($email){
        $sql = "SELECT * FROM ".static::$tableName. " WHERE email = '{$email}'";
        $stmt = DatabaseHandler::instance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        $obj=array_shift($result);
          return $obj;
    }
    public function updateCode(){
        $sql = "UPDATE " . static::$tableName . " SET code = :code WHERE ". static::$primaryKey . " = :id";
        $stmt = DatabaseHandler::instance()->prepare($sql);
        $stmt->bindValue(':code', $this->code, self::DATA_TYPE_INT);
        $stmt->bindValue(':id', $this->{static::$primaryKey}, self::DATA_TYPE_INT);
        return $stmt->execute();
    }
    public static function get($query){
        $stmt = DatabaseHandler::instance()->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        $obj=array_shift($result);
        return $obj;
    }
    public static function getLastId(){
        return DatabaseHandler::instance()->lastInsertId();
    }
    public function __destruct()
    {
       DatabaseHandler::close();
    }
    
}
