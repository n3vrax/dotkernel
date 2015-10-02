<?php

namespace DotUser\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Mapper\UserDetailsDbMapper;

class UserDetailsDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $config = $serviceLocator->get('config');
        
        if(!isset($config['dotuser']['db_adapter']) || empty($config['dotuser']['db_adapter']))
        {
            throw new \Exception('db adapter config key must be set to a valid database adapter service name');
        }
            
        $dbAdapter = $serviceLocator->get($config['dotuser']['db_adapter']);
        
        $userDetailsEntityName = isset($config['dotuser']['user_details_entity']) ?
                                    $config['dotuser']['user_details_entity'] :
                                    'DotUser\Entity\UserDetailsEntity';
        
        $entityPrototype = $serviceLocator->get($userDetailsEntityName);
        
        $hydratorName = isset($config['dotuser']['user_details_hydrator']) ?
                            $config['dotuser']['user_details_hydrator'] :
                            'DotUser\Entity\UserDetailsHydrator';
        
        $hydrator = $serviceLocator->get('HydratorManager')->get($hydratorName);
        
        $mapper = new UserDetailsDbMapper();
        
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype($entityPrototype)
               ->setHydrator($hydrator);
        
        return $mapper;
    }
}