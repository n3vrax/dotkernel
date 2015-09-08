<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserDetailsHydrator;

class UserDetailsHydratorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydrator = new UserDetailsHydrator();
        return $hydrator;
    }
}