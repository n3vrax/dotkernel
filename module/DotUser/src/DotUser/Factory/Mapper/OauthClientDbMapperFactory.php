<?php

namespace DotUser\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Mapper\OauthClientDbMapper;
use Zend\Stdlib\Hydrator\ClassMethods;

class OauthClientDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $config = $serviceLocator->get('config');
        
        if(!isset($config['dotuser']['db_adapter']) || empty($config['dotuser']['db_adapter']))
        {
            throw new \Exception('db adapter config key must be set to a valid database adapter service name');
        }
            
        $dbAdapter = $serviceLocator->get($config['dotuser']['db_adapter']);
        
        $entityPrototype = $serviceLocator->get('DotUser\Entity\OauthClientEntity');
        
        $mapper = new OauthClientDbMapper();
        
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype($entityPrototype)
               ->setHydrator(new ClassMethods(true));
        
        return $mapper;
    }
}