<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserHydrator;

class UserHydratorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydrator = new UserHydrator();
        $hydratingStrategy = $serviceLocator->getServiceLocator()->get('dotuser_user_hydrating_strategy');
        
        $hydrator->addStrategy('details', $hydratingStrategy);
        return $hydrator;
    }
}