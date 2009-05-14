<?php

class Tunes_View_Helper_BaseUrl
{
    protected $_request;
    
    public function __construct()
    {
        $this->_request = Zend_Controller_Front::getInstance()->getRequest();
    }
    
    public function baseUrl()
    {
        return $this->_request->getBaseUrl();
    }
}