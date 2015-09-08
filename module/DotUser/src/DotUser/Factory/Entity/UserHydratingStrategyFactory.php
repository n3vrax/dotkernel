<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserHydratingStrategy;

class UserHydratingStrategyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydrator = $serviceLocator->get('HydratorManager')->get('dotuser_user_details_hydrator');
        $entityPrototype = $serviceLocator->get('dotuser_user_details_entity');
        
        return new UserHydratingStrategy($hydrator, $entityPrototype);
    }
}