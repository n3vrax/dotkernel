<?php

namespace DotBase\Validator;

use Zend\Validator\StringLength;

class StringLengthIgnoreNull extends StringLength
{ 
    public function isValid($value)
    {
        if(null === $value) return true;
        return parent::isValid($value);
    }
}