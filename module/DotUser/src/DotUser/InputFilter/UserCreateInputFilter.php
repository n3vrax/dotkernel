<?php

namespace DotUser\InputFilter;

use Zend\InputFilter\InputFilter;

class UserCreateInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 6,
                        'max' => 255,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(),
                ),
            ),
        ));
    }
}