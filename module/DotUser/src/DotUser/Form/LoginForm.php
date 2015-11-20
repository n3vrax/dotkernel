<?php

namespace DotUser\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
class LoginForm extends Form
{
    public function __construct($name = 'login', $options = array())
    {
        parent::__construct($name, $options);
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'identity',
            'type' => 'text',
            'options' => array(
                'label' => 'Username or Email',
            ),
    
        ));
        $this->add(array(
            'type' => 'password',
            'name' => 'credential',
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Sign In',
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if(!$this->filter)
        {
            $this->filter = new InputFilter();
            $this->filter->add(array(
                'name'       => 'credential',
                'required'   => true,
                'filters'    => array(),
            ));
    
            $this->filter->add(array(
                'name'       => 'identity',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 255,
                        ),
                    ),
                )
            ));
        }
        return $this->filter;
    }
}