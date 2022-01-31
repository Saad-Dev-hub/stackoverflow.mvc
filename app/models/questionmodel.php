<?php

namespace PHPMVC\Models;

class  QuestionModel extends AbstractModel
{
    private $id;
    private $title;
    private $body;
    private $category;
    private $user_id;
    private $created_at;
    private $updated_at;

    public static $tableName = 'question';
    protected static $primaryKey = 'id';
    public static $tableSchema = array(
        'title'    => self::DATA_TYPE_STR,
        'body'  => self::DATA_TYPE_STR,
        'category'  => self::DATA_TYPE_STR,
        'user_id' => self::DATA_TYPE_INT,
    );

    public function __construct($title, $body, $category, $user_id)
    {
        $this->title = $title;
        $this->body = $body;
        $this->category = $category;
        $this->user_id = $user_id;
    }
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    public function getId()
    {
        return $this->id;
    }




}
