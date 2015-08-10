<?php

namespace DotUser\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ChangeEmailForm extends Form
{
    public function __construct($name = 'change_email', $options = array())
    {
        parent::__construct($name, $options);
        $this->init();    
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'New Email',
            ),
            
        ));
        $this->add(array(
            'type' => 'password',
            'name' => 'password',
            'options' => array(
                'label' => 'Your Password',
            ),
        ));
        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Change Email',
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if(!$this->filter)
        {
            $this->filter = new InputFilter();
            $this->filter->add(array(
                'name'       => 'password',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
            ));
            
            $this->filter->add(array(
                'name'       => 'email',
                'required'   => true,
                'validators' => array(
                    array(
                        'name' => 'EmailAddress'
                    ),
                )     
            ));
        }
        return $this->filter;
    }
}