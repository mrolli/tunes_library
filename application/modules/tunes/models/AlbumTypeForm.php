<?php

require_once 'Zend/Form.php';

class AlbumTypeForm extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();
        
        $name = new Zend_Form_Element_Text('label');
        $name->setRequired(true)
             ->setLabel('Album Type Label')
             ->setAttrib('size', 45)
             ->setDescription('The album type\'s label.')
             ->addFilter('StripTags');
        $this->addElement($name);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $this->addElement($submit);
        
        $cancel = new Zend_Form_Element_Button('cancel');
        $cancel->setAttrib('onclick', 'history.back()')
               ->setValue('Cancel');
        $this->addElement($cancel);
        
        $this->setMethod('post');
    }
}