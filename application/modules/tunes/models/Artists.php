<?php

require_once 'Zend/Db/Table/Abstract.php';

class Artists extends Zend_Db_Table_Abstract
{
    protected $_name    = 'artists';
    protected $_primary = 'id';
    
    protected $_dependentTables = array('Albums');
}
