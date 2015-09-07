<?php

namespace DotMailTransporter\Form;

use Zend\InputFilter\InputFilter;

class TransporterCreateInputFilter extends InputFilter
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
            'name' => 'hostname',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 255,
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\Hostname',
                    'options' => array(
                        'allow' => \Zend\Validator\Hostname::ALLOW_ALL,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'port',
            'required' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'Zend\I18n\Validator\IsInt',
                    'options' => array(),
                ),
            ),
        ));
        
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
                        'max' => 255,
                        'min' => 3,
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
                        'max' => 255,
                        'min' => 3,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'connectionClass',
            'required' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'InArray',
                    'options' => array(
                        'haystack' => array(
                            'smtp',
                            'plain',
                            'login',
                            'crammd5',
                        ),
                        'message' => 'Valid connection class types are smtp, plain, login and crammd5',
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'secure',
            'required' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'InArray',
                    'options' => array(
                        'haystack' => array(
                            'ssl',
                            'tls',
                        ),
                        'message' => 'Invalid secure connection - allowed values ssl or tls',
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'active',
            'required' => true,
            'filters' => array(),
            'validators' => array(
                array(
                    'name' => 'DotBase\Validator\IsBoolean',
                    'options' => array(
                    ),
                ),
            ),
        ));
    }
}