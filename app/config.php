<?php
// MAIN CONFIGURATION FILE
namespace PHPMVC;
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}
define('APP_PATH',realpath(dirname(__FILE__)));
define('VIEWS_PATH',APP_PATH.DS.'views'.DS);
define('DATABASE_HOST_NAME','localhost');
define('DATABASE_USER_NAME','root');
define('DATABASE_PASSWORD','');
define('DATABASE_NAME','stackoverflow');
define("CSS_PATH", "assets/css");
define("JS_PATH", "assets/js");
define('UPLOAD_PATH',"uploads/");