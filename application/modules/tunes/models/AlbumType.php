<?php

require_once 'Zend/Db/Table/Abstract.php';

class AlbumType extends Zend_Db_Table_Abstract
{
    protected $_name    = 'album_type';
    protected $_primary = 'id';
    
    protected $_dependentTables = array('Albums');
}
