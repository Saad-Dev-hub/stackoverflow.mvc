<?php

namespace PHPMVC\LIB;

trait Validation
{

    private $_regexPatterns = [
        'alpha' => '/^[a-zA-Z0-9\s.\-]+$/',
        'alphanumeric' => '/^[a-zA-Z0-9]+$/',
        'numeric' => '/^[0-9]+(?:\.[0-9]+)?$/',
        'float' => '/^[0-9]+\.[0-9]+$/',
        'email' => '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',
        'time' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
        'datetime' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',
        'password'  => '/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/'
    ];
    //make required function to check if the field is empty or not
    public function required($field, $fieldName = null)
    {
        if (empty($field)) {
            $this->_errors[] = ("<b>{$fieldName}</b> is required");
        }
        return $this;
    }
    public function minLength($field, $length, $fieldName = null)
    {
        if (mb_strlen($field) < $length) {
            $this->_errors[] = ("<b>{$fieldName}</b> must be at least {$length} characters long");
        }
        return $this;
    }
    public function maxLength($field, $length, $fieldName = null)
    {
        if (mb_strlen($field) > $length) {
            $this->_errors[] = ("<b>{$fieldName}</b> must be less than {$length} characters long");
        }
        return $this;
    }

    public function is_number($value, $fieldName = null)
    {
        if (!is_numeric($value)) {
            $this->_errors[] = ("<b>{$fieldName}</b> must be a number");
        }
        return $this;
    }
    public function is_string($value, $fieldName = null)
    {
        if (!preg_match($this->_regexPatterns['alpha'], $value)) {
            $this->_errors[] = "<b>{$fieldName}</b> must be a string";
        }
        return $value;
    }
    // 
    public function is_date($value)
    {
        // DATE FORMAT MUST BE LIKE THIS: 2019-01-01 00:00:00 //date('Y-m-d H:i:s')
        // (TIMESTAMP)
        if (!preg_match($this->_regexPatterns['datetime'], $value)) {
            $this->_errors[] = 'The value must be a date';
        }
    }
    public function is_email($value, $fieldName = null)
    {
        if (!preg_match($this->_regexPatterns['email'], $value)) {
            $this->_errors[] = "<b>{$fieldName}</b> must be a valid email address";
        }
        return $value;
    }
    public function getErrors_img()
    {
        return (!empty($this->_errors_img)) ? $this->_errors_img : null;
    }
    // make function to validate using all the functions above
    public function passwordFormat($value)
    {
        if (!preg_match($this->_regexPatterns['password'], $value)) {
            $this->_errors[] = '<b>Password</b> must contain at least one lowercase letter, one uppercase letter, one number and one special character';
        }
        return $value;
    }
    public function encryptPassword($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }
    public function decryptPassword($value, $hash)
    {
        return password_verify($value, $hash);
    }
    public function confirmPassword($value, $fieldName = null)
    {
        if ($value != $_POST['password']) {
            $this->_errors[] = "<b>{$fieldName}</b> must be the same as password";
        }
        return $value;
    }
    // make funtion to upload image to uploads folder in public folder
    public function validateFiles($name)
    {
        //check if the file is uploaded
        if (isset($name['name']) && !empty($name['name'])) {
            $this->_errors_img = [];
            $file_size = $name['size'];
            $file_tmp = $name['tmp_name'];
            $file_type = $name['type'];
            $tmp = explode('.', $name['name']);
            $file_ext = strtolower(end($tmp));
            $extensions = array("jpeg", "jpg", "png");
            $file_name = time() . rand(1, 1000) . '.' . $file_ext;
            $target_dir = 'uploads/' . $file_name;
            if (!in_array($file_ext, $extensions)) {
                $this->_errors_img[] = "extension not allowed, please choose a JPEG or PNG file.";
            }
            // check if the file type is pdf  
            // if ($file_type != 'image/jpeg' && $file_type != 'image/jpg' && $file_type != 'image/png') {
            //     $this->_errors_img[] = "extension not allowed, please choose a JPEG or PNG file.";
            // }


            
            if ($file_size > 2097152) {
                $this->_errors_img[] = 'File size must be less than 2 MB';
            }
            if (empty($this->_errors_img) && empty($this->_errors)) {
                move_uploaded_file($file_tmp, "uploads/" . $file_name);
                return $target_dir;
            } else {
                return false;
            }
        }
    }

    public function printError()
    {
        if (!empty($this->_errors)) {
            return $this->_errors;
        }
        return [];
    }
    
    public function printErrorImg()
    {
        if (!empty($this->_errors_img)) {
            return $this->_errors_img;
        }
        return [];
    }
}
