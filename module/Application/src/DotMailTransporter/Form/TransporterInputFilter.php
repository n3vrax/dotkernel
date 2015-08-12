<?php

namespace DotMailTransporter\Form;

use Zend\InputFilter\InputFilter;

class TransporterInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 255,
                        'min' => 3,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'connectionClass',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'type' => array('string'),
                        'message' => 'Field is optional but value cannot be empty'
                    ),
                ),
                array(
                    'name' => 'InArray',
                    'options' => array(
                        'haystack' => array(
                            'smtp',
                            'plain',
                            'login',
                            'crammd5',
                            null,
                        ),
                        'message' => 'Valid connection types are smtp, plain, login and crammd5',
                    ),
                ),
            ),
        ));
    }
}