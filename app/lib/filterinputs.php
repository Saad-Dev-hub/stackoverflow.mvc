<?php

namespace PHPMVC\LIB;

trait FilterInputs
{
    private $errors = [];

    public function required($input, $fieldName = '')
    {
        if (empty($input)) {
            $this->errors[] =  "The $fieldName  is required";
        }
        return trim($input);
    }
    public function filterString($string, $fieldName = '')
    {
        if (empty($string)) {
            $this->errors[] = "The $fieldName  is required";
        }
        $string = trim($string);
        $string = htmlspecialchars($string);

        return filter_var($string, FILTER_SANITIZE_STRING);
    }


    public function filterCodeSnippet($input,$fieldName='')
    {
        $this->required($input, $fieldName);
        return trim(stripslashes(htmlspecialchars($input)));
    }
    function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    public function showErrors()
    {
        if (!empty($this->errors)) {
            return $this->errors;
        }
        return [];
    }
}
