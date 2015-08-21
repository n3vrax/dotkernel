<?php

namespace DotBase\Validator;

use Zend\Validator\AbstractValidator;

class IsBooleanIgnoreNull extends AbstractValidator
{
    const IS_BOOLEAN = 'isBoolean';
    
    protected $messageTemplates = array(
        self::IS_BOOLEAN => "Field is not a boolean value",
    );
    
    public function isValid($value)
    {
        $this->setValue($value);
        
        if(null !== $value && !is_bool($value)){
            $this->error(self::IS_BOOLEAN);
            return false;
        }
        
        return true;
    }
}