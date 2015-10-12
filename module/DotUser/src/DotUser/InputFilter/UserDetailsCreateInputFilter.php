<?php

namespace DotUser\InputFilter;

use Zend\InputFilter\InputFilter;

class UserDetailsCreateInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'firstName',
            'required' => false,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 255
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'lastName',
            'required' => false,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 255
                    ),
                ),
            ),
        ));
    }

}