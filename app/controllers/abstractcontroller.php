<?php

namespace PHPMVC\Controllers;

use PHPMVC\LIB\FrontController;

class AbstractController
{
    protected $_controller;
    protected $_action;
    protected $_params;
    protected $_data = [];
    public function notFoundAction()
    {
        $this->_view();
    }
    public function setController($controllername)
    {
        $this->_controller = $controllername;
    }
    public function setAction($actionname)
    {
        $this->_action = $actionname;
    }
    public function setParams($params)
    {
        $this->_params = $params;
    }
    protected function _view()
    {
        if ($this->_action == FrontController::NOT_FOUND_ACTION) {
            require_once VIEWS_PATH . DS . 'notfound' . DS . 'notfound.view.php';
        } else {
            $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
            if (file_exists($view)) {
                extract($this->_data);
                require_once $view;
            }           
        }
    }
    
    
}
