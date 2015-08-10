<?php

namespace DotUser\Validator;

use ZfcUser\Validator\AbstractRecord;
use ZfcUser\Entity\UserInterface;

class UsernameUpdateExists extends AbstractRecord
{
    protected $user;
    
    public function setCurrentUser(UserInterface $user)
    {
        $this->user = $user;
    }
    
    public function isValid($value)
    {
        if(!$this->user)
            throw new \Exception('current username was not set - cannot validate username');
            
        $valid = true;
        $this->setValue($value);
        
        $result = $this->query($value);
        if ($result && $result->getId() !== $this->user->getId()) {
            $valid = false;
            $this->error(self::ERROR_RECORD_FOUND);
        }
        
        return $valid;
    }
}