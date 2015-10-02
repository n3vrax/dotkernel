<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserHydratingStrategy;

class UserHydratingStrategyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $hydratorName = isset($config['dotuser']['user_details_hydrator']) ? 
                            $config['dotuser']['user_details_hydrator'] : 
                            'DotUser\Entity\UserDetailsHydrator';
        
        $hydrator = $serviceLocator->get('HydratorManager')->get($hydratorName);
        
        $userDetailsEntityName = isset($config['dotuser']['user_details_entity']) ? 
                                    $config['dotuser']['user_details_entity'] : 
                                    'DotUser\Entity\UserDetailsEntity';
        
        $entityPrototype = $serviceLocator->get($userDetailsEntityName);
        
        return new UserHydratingStrategy($hydrator, $entityPrototype);
    }
}