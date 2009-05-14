<?php

require_once 'Zend/Db/Table/Abstract.php';

class Albums extends Zend_Db_Table_Abstract
{
    protected $_name = 'albums';
    protected $_primary = 'id';
    
    protected $_referenceMap = array(
        'Artist' => array(
            'columns'       => 'artist_id',
            'refTableClass' => 'Artists',
            'refColumns'    => 'id',
        ),
        'AlbumType' => array(
            'columns'       => 'album_type_id',
            'refTableClass' => 'AlbumType',
            'refColumns'    => 'id',
        ),
    );
}
