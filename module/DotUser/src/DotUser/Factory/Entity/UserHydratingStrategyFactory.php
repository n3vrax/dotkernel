<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserHydratingStrategy;

class UserHydratingStrategyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydrator = $serviceLocator->get('HydratorManager')->get('DotUser\Entity\UserDetailsHydrator');
        $entityPrototype = $serviceLocator->get('DotUser\Entity\UserDetailsEntity');
        
        return new UserHydratingStrategy($hydrator, $entityPrototype);
    }
}