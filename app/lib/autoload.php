<?php

namespace PHPMVC\LIB;

class Autoload
{
    public static function autoload($classname)
    {
        //remove main namespace
        $classname = str_replace('PHPMVC', '', $classname);
        $path = APP_PATH . strtolower($classname) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
}
spl_autoload_register(__NAMESPACE__ . '\Autoload::autoload');






