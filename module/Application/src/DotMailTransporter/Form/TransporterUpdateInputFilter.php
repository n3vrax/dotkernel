<?php

namespace DotMailTransporter\Form;

use Zend\InputFilter\InputFilter;

class TransporterUpdateInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'name' => 'name',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Application\Validator\StringLengthIgnoreNull',
                    'options' => array(
                        'max' => 255,
                        'min' => 3,
                        'message' => 'Invalid name field - must be a string between 3 and 255 characters'
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'hostname',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Application\Validator\StringLengthIgnoreNull',
                    'options' => array(
                        'max' => 255,
                        'min' => 1,
                        'breakchainonfailure' => true,
                    ),
                ),
                array(
                    'name' => 'Application\Validator\HostnameIgnoreNull',
                    'options' => array(
                        'allow' => \Zend\Validator\Hostname::ALLOW_ALL,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'port',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'Application\Validator\IsIntIgnoreNull',
                    'options' => array(),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'username',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Application\Validator\StringLengthIgnoreNull',
                    'options' => array(
                        'max' => 255,
                        'min' => 3,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'Application\Validator\StringLengthIgnoreNull',
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
                        'type' => 'string',
                        'message' => 'Valid connection class types are smtp, plain, login and crammd5',
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
                        'message' => 'Valid connection class types are smtp, plain, login and crammd5',
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'secure',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'type' => 'string',
                        'message' => 'Invalid secure connection - allowed values ssl or tls',
                    ),
                ),
                array(
                    'name' => 'InArray',
                    'options' => array(
                        'haystack' => array(
                            'ssl',
                            'tls',
                            null,
                        ),
                        'message' => 'Invalid secure connection - allowed values ssl or tls',
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'active',
            'required' => false,
            'continue_if_empty' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'Application\Validator\IsBooleanIgnoreNull',
                    'options' => array(
                        
                    ),
                ),
            ),
        ));
    }
}