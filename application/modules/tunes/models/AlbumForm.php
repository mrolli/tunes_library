<?php

class AlbumForm extends Zend_Form
{
    protected $_defaultTextSize = 40;
    protected $_defaultStringFilters = array('StripTags', 'StringTrim');

    public function __construct()
    {
        parent::__construct();

        $name = new Zend_Form_Element_Text('name');
        $name->setRequired(true)
             ->setLabel('Album Name')
             ->setAttrib('size', $this->_defaultTextSize)
             ->setFilters($this->_defaultStringFilters);

        $version = new Zend_Form_Element_Text('version');
        $version->setLabel('Version')
                ->setDescription('i.e. UK Version, Japanse Edition, ...')
                ->setAttrib('size', $this->_defaultTextSize)
                ->setFilters($this->_defaultStringFilters);
        
        $year = new Zend_Form_Element_Text('year');
        $year->setLabel('Release Year')
             ->setRequired(true)
             ->setAttrib('size', 4)
             ->addValidator('Int', true)
             ->addValidator('Regex', true, array('pattern' => '/[1-9][0-9]{3}/'));

        $albumType = new Zend_Form_Element_Select('album_type_id');
        $albumType->setLabel('Album Type')
                  ->setRequired(true);

        $typeTable = new AlbumType();
        $types = $typeTable->fetchAll();
        foreach ($types as $type) {
            $albumType->addMultiOption($type->id, $type->label);
        }
        
        $missing  = $this->_generateRadio('missing', 'Is the album missing?');
        $complete = $this->_generateRadio('complete', 'Is the album complete?');
        $corrupt  = $this->_generateRadio('corrupt', 'Album with corrupt songs?');
        $cover    = $this->_generateRadio('cover', 'Is the album cover available?');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setIgnore(true)
               ->setLabel('Save');
        
        $cancel = new Zend_Form_Element_Button('cancel');
        $cancel->setIgnore(true)
               ->setLabel('Cancel')
               ->setAttrib('onclick', 'history.back()');

        $this->addElements(array($name, $version, $year, $albumType, $missing, $complete, $corrupt, $cover, $submit, $cancel));
    }
    
    protected function _generateRadio($name, $label)
    {
        $field = new Zend_Form_Element_Radio($name);
        $field->setLabel($label)
              ->setRequired(true);
        $field->addMultiOption(2, 'Yes');
        $field->addMultiOption(1, 'No');
        return $field;
    }
}