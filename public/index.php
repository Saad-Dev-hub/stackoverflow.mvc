<?php

namespace PHPMVC;

use PHPMVC\LIB\AppSessionHandler;
use PHPMVC\LIB\FrontController;


if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}
require_once '..'.DS.'app'.DS.'config.php';
require_once APP_PATH.DS.'lib'.DS.'autoload.php';
$session=new AppSessionHandler();
$session->start();
if(!$session->isValidFingerPrint()){
    $session->kill();
}
$front=new FrontController();
$front->dispatch();
