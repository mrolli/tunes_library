<?php

class Tunes_View_Helper_ColorizeAlbum
{
    protected $_tagName = 'span';
    
    protected $_album = null;

    public function colorizeAlbum($album = null)
    {
        if ($album instanceof Zend_Db_Table_Row) {
        	$this->_album = $album;
        }
        return $this;
    }
    
    public function getColorLegend()
    {
        $code = '<ul><li><span class="album_ok">Album complete and clean</span></li>';
        $code.= '<li><span class="album_error">Album incomplete or corrupt or missing cover. See Details</span></li>';
        $code.= '<li><span class="album_missing">Album missing completely.</span></li></ul>';
        return $code;
    }
    
    protected function _toString()
    {
        $code = '<' . $this->_tagName;
        if ($this->_album->missing) {
            $code.= ' class="album_missing"'; 
        } elseif ($this->_album->complete && $this->_album->cover && !$this->_album->corrupt) {
            $code.= ' class="album_ok"';
        } else {
            $code.= ' class="album_error"';
        }
        $code.= '>' . $this->_album->name . '</' . $this->_tagName . '>';
        return $code;
    }
    
    public function __toString()
    {
        return $this->_toString();
    }
}