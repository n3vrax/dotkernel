<?php

namespace DotMailTransporter\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

class TransporterEntityHydrator extends ClassMethods
{
    public function __construct($underscoreSeparatedKeys = false)
    {
        parent::__construct($underscoreSeparatedKeys);
    }
}