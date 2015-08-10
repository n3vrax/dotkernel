<?php

namespace DotUser\Form;

use Zend\Form\Form;

class UserDetailsForm extends Form
{   
    public function __construct($name = 'user_details', $options = array())
    {
        parent::__construct($name, $options);
        $this->init();
    }
    
    public function getUsernameValidator()
    {
        return $this->usernameValidator;
    }
    
    public function init()
    {  
        $this->add(array(
            'type' => 'text',
            'name' => 'username',
            'options' => array(
                'label' => 'Username',
            ),
        ));
        
        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Save',
            ),
        ));
    }
}