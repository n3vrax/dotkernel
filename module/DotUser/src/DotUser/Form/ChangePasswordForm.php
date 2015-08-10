<?php

namespace DotUser\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ChangePasswordForm extends Form
{
    public function __construct($name = 'change_password', $options = array())
    {
        parent::__construct($name, $options);
        
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'type' => 'password',
            'name' => 'old_password',
            'options' => array(
                'label' => 'Old Password',
            ),
        ));
        
        $this->add(array(
            'type' => 'password',
            'name' => 'new_password',
            'options' => array(
                'label' => 'New Password',
            ),
        ));
        
        $this->add(array(
            'type' => 'password',
            'name' => 'new_password_verify',
            'options' => array(
                'label' => 'Retype Password',
            ),
        ));
        
        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Change password',
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if(!$this->filter)
        {
            $this->filter = new InputFilter();
            $this->filter->add(array(
                'name'       => 'old_password',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
            ));
            $this->filter->add(array(
                'name'       => 'new_password',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                        ),
                    ),
                ),
            ));
            $this->filter->add(array(
                'name'       => 'new_password_verify',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                        ),
                    ),
                    array(
                        'name'    => 'Identical',
                        'options' => array(
                            'token' => 'new_password',
                        ),
                    ),
                ),
            ));
        }
        
        return $this->filter;
    }
}