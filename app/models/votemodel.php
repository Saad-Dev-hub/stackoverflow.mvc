<?php

namespace PHPMVC\Models;
use PHPMVC\LIB\Database\DatabaseHandler;

class VoteModel extends AbstractModel
{
    private $id;
    private $upvote;
    private $downvote;
    private $user_id;
    private $answer_id;
    private $question_id;
    private $created_at;
    private $updated_at; 
    protected static $tableName = 'vote';
    protected static $tableSchema = array(
        'id' => self::DATA_TYPE_INT,
        'upvote' => self::DATA_TYPE_INT,
        'downvote' => self::DATA_TYPE_INT,
        'user_id' => self::DATA_TYPE_INT,
        'answer_id' => self::DATA_TYPE_INT,
        'question_id' => self::DATA_TYPE_INT,
        'created_at' => self::DATA_TYPE_STR,
        'updated_at' => self::DATA_TYPE_STR
    );
    protected static $primaryKey = 'id';
    public function __construct( $upvote, $downvote, $user_id,$question_id, $answer_id)
    {
        $this->upvote = $upvote;
        $this->downvote = $downvote;
        $this->user_id = $user_id;
        $this->question_id = $question_id;
        $this->answer_id = $answer_id;
    }
    public function __get($prop)
    {
        return $this->$prop;
    }
    public function __set($prop, $value)
    {
        $this->$prop = $value;
    }
    
    
}
