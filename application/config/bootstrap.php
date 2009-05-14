<?php

define('APP_ROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

$include_path = array();
$include_path[] = '.';
$include_path[] = APP_ROOT . '../library';
$include_path[] = APP_ROOT . 'modules/default/models';
$include_path[] = APP_ROOT . 'modules/tunes/models';
$include_path[] = get_include_path();
set_include_path(implode(PATH_SEPARATOR, $include_path));

require_once 'Zend/Loader.php';
Zend_Loader::registerAutoload();

$db_params = array('host' => 'localhost', 'username' => 'root', 'password' => 'D50bP69w', 'dbname' => 'archive_mp3_test');
$db = Zend_Db::factory('Mysqli', $db_params);
Zend_Db_Table_Abstract::setDefaultAdapter($db);
Zend_Registry::set('db', $db);
$db->query('SET NAMES utf8');

$layout = new Zend_Layout(
    array(
        'layout'     => 'standard',
        'layoutPath' => APP_ROOT . 'layouts',
    ),
    true
);

$view = $layout->getView();
$view->addHelperPath(APP_ROOT . 'modules/tunes/views/helpers', 'Tunes_View_Helper_');
$view->setEncoding('UTF-8');
$view->doctype('XHTML1_TRANSITIONAL');
$view->headTitle('Tunes')->setSeparator(' » ')->setIndent(4);
$view->headMeta()->appendHttpEquiv('Content-type', 'text/html; charset=utf-8')
                 ->appendName('copyright', 'Michael Rolli')
                 ->appendName('author', 'Michael Rolli')
                 ->setIndent(4);

