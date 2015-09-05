<?php

namespace DotUser\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

class UserDetailsHydrator extends ClassMethods
{
    public function __construct()
    {
        parent::__construct(false);
    }
}