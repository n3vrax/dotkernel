<?php

namespace DotUser\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Mapper\UserRoleDbMapper;

class UserRoleDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $config = $serviceLocator->get('config');
        
        if(!isset($config['dotuser']['db_adapter']) || empty($config['dotuser']['db_adapter']))
        {
            throw new \Exception('db adapter config key must be set to a valid database adapter service name');
        }
            
        $dbAdapter = $serviceLocator->get($config['dotuser']['db_adapter']);
        
        $entityPrototype = $serviceLocator->get('DotUser\Entity\UserRoleEntity');
        
        $hydrator = $serviceLocator->get('HydratorManager')->get('DotUser\Entity\UserRoleHydrator');
        
        $mapper = new UserRoleDbMapper();
        
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype($entityPrototype)
               ->setHydrator($hydrator);
        
        return $mapper;
    }
}