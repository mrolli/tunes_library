<?php

require_once 'Zend/Controller/Action.php';

class IndexController extends Zend_Controller_Action 
{
    public function indexAction() 
    {
        $this->_helper->Redirector->goto('index', 'index', 'tunes');
    }
}
