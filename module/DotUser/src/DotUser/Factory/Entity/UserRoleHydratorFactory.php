<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserRoleHydrator;

class UserRoleHydratorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydrator = new UserRoleHydrator();
        return $hydrator;
    }
}