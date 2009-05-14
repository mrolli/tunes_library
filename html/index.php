<?php

require_once dirname(dirname(__FILE__)) . '/application/config/bootstrap.php';

require_once 'Zend/Controller/Front.php';

$controller = Zend_Controller_Front::getInstance();
$controller->addModuleDirectory(APP_ROOT . 'modules/');
$controller->throwExceptions(false);

$controller->dispatch();