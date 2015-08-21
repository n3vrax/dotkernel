<?php

namespace DotBase\Validator;

use Zend\Validator\AbstractValidator;

class EmailAddressArray extends AbstractValidator
{
    const EMAIL_INVALID = 'emailInvalid';
    const INVALID_TYPE = 'invalidType';
    
    protected $emailAddressValidator;
        
    protected $messageTemplates = array(
        self::EMAIL_INVALID => "Some of the email addresses are not valid",
        self::INVALID_TYPE => "Invalid type - expected array or string",
    );
    
    public function __construct($emailAddressValidator, $options = null)
    {
        parent::__construct($options);
        $this->emailAddressValidator = $emailAddressValidator;
    }
    
    public function isValid($value)
    {
        $isValid = true;
        
        if(is_string($value))
            $value = array($value);
        
        if(!is_array($value))
        {
            $this->error(self::INVALID_TYPE);
            return false;
        }
        
        foreach ($value as $email)
        {
            if(!$this->emailAddressValidator->isValid($email))
            {
                $isValid = false;
                break;
            }
        }
        
        if(!$isValid)
        {
            $this->error(self::EMAIL_INVALID);
            return false;
        }
        
        return true;
        
    }

    
}