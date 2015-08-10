<?php

namespace DotUser\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ResetPasswordForm extends Form
{
    public function __construct($name = 'reset_password', $options = array())
    {
        parent::__construct($name, $options);
        
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'New Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'password_verify',
            'type' => 'password',
            'options' => array(
                'label' => 'Re-type New Password',
            ),
        ));
        
        $this->add(array(
            'type' => 'hidden',
            'name' => 'email',
        ));
        
        $this->add(array(
            'type' => 'hidden',
            'name' => 'token',
        ));
        
        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Reset Password'
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if(!$this->filter)
        {
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'password',
                'required' => true,
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
            
            $inputFilter->add(array(
                'name' => 'password_verify',
                'required' => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                        ),
                    ),
                    array(
                        'name'    => 'identical',
                        'options' => array(
                            'token' => 'password',
                        ),
                    ),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'email',
                'required' => true,
                'filters' => array(array('name' => 'StringTrim')),
            ));
            $inputFilter->add(array(
                'name' => 'token',
                'required' => true,
                'filters' => array(array('name' => 'StringTrim')),
            ));
            
            $this->filter = $inputFilter;
        }
        return $this->filter;
    }
}