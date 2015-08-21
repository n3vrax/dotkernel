<?php

namespace DotBase\Validator;

use Zend\I18n\Validator\IsInt;

class IsIntIgnoreNull extends IsInt
{ 
    public function isValid($value)
    {
        if(null === $value) return true;
        return parent::isValid($value);
    }
}