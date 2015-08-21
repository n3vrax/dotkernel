<?php

namespace DotBase\Validator;

use Zend\Validator\Hostname;

class HostnameIgnoreNull extends Hostname
{ 
    public function isValid($value)
    {
        if(null === $value) return true;
        return parent::isValid($value);
    }
}