<?php  

namespace PHPMVC\Models;
class AnswerModel extends AbstractModel{

    private $id;
    private $body;
    private $user_id;
    private $question_id;
    private $created_at;
    private $updated_at;

    public static $tableName = 'answer';
    protected static $primaryKey = 'id';
    public static $tableSchema = array(
        'user_id' => self::DATA_TYPE_INT,
        'question_id'   => self::DATA_TYPE_INT,
        'body'          => self::DATA_TYPE_STR,
    );


    public function __construct( $question_id,$user_id,$body)
    {   
        $this->question_id = $question_id;
        $this->user_id = $user_id;
        $this->body = $body;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}