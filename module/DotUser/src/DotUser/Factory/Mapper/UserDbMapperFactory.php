<?php

namespace DotUser\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Mapper\UserDbMapper;

class UserDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        
        if(!isset($config['dotuser']['db_adapter']) || empty($config['dotuser']['db_adapter']))
        {
            throw new \Exception('db adapter config key must be set to a valid database adapter service name');
        }
            
        $dbAdapter = $serviceLocator->get($config['dotuser']['db_adapter']);
        
        $userEntity = $serviceLocator->get('dotuser_user_entity');
        $userHydrator = $serviceLocator->get('HydratorManager')->get('dotuser_user_hydrator');
        
        $mapper = new UserDbMapper();
        
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype($userEntity)
               ->setHydrator($userHydrator);
        
        return $mapper;
    }
}