<?php

namespace DotUser\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\ValidatorInterface;

class UserDetailsInputFilter extends InputFilter
{
    protected $usernameValidator;
    
    public function __construct(ValidatorInterface $usernameValidator)
    {
        $this->usernameValidator = $usernameValidator;
        $this->init();
    }
    
    public function getUsernameValidator()
    {
        return $this->usernameValidator;
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
                        'max' => 255,
                        'min' => 3,
                    ),
                ),
                $this->usernameValidator,
            ),
        ));
    }
}