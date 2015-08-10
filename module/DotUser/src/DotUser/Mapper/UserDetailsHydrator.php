<?php

namespace DotUser\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;
use DotUser\Entity\UserDetails;

class UserDetailsHydrator extends ClassMethods
{
    public function __construct($underscoreSeparatedKeys = false)
    {
        parent::__construct($underscoreSeparatedKeys);
    }
    
    public function extract($object)
    {
        if(!$object instanceof UserDetails)
        {
            return $object;
        }
        return parent::extract($object);
    }
    
    public function hydrate(array $data, $object)
    {
        if(!$object instanceof UserDetails)
        {
            return $object;
        }
        return parent::hydrate($data, $object);
    }
}