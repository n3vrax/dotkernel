<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserHydratingStrategy;
use DotUser\Entity\UserDetailsEntity;
use DotUser\Entity\UserHydrator;
use DotUser\Entity\UserDetailsHydrator;

class UserHydratorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydrator = new UserHydrator();
        
        $hydrator->addStrategy('details', new UserHydratingStrategy(new UserDetailsHydrator(), new UserDetailsEntity()));
        return $hydrator;
    }
}