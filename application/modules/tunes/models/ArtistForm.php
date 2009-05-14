<?php

require_once 'Zend/Form.php';

class ArtistForm extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setMethod('post');
        $name = new Zend_Form_Element_Text('name');
        $name->setRequired(true)
             ->setLabel('Artists Name')
             ->setDescription('The artists exact name.')
             ->setAttrib('size', 45);
        
        $discography = new Zend_Form_Element_Textarea('discography');
        $discography->setLabel('Discography')
                    ->setDescription('Links to internet pages referencing discography daa.')
                    ->setAttribs(array('cols' => 45, 'rows' => 10));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setIgnore(true)
               ->setLabel('Save');
        
        $cancel = new Zend_Form_Element_Button('cancel');
        $cancel->setIgnore(true)
               ->setLabel('Cancel')
               ->setAttrib('onclick', 'history.back()');
               
        $this->addElements(array($name, $discography, $submit, $cancel));
    }
}