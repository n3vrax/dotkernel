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
        
        $userEntity = isset($config['dotuser']['user_entity']) && !empty($config['dotuser']['user_entity']) ? 
                        $serviceLocator->get($config['dotuser']['user_entity']) : 
                        $serviceLocator->get('DotUser\Entity\UserEntity');
        
        $userHydrator = isset($config['dotuser']['user_hydrator']) && !empty($config['dotuser']['user_hydrator']) ? 
                            $serviceLocator->get('HydratorManager')->get($config['dotuser']['user_hydrator']) : 
                            $serviceLocator->get('HydratorManager')->get('DotUser\Entity\UserHydrator'); 
        
         $userDetailsMapper = isset($config['dotuser']['user_details_mapper']) && !empty($config['dotuser']['user_details_mapper']) ? 
                                    $serviceLocator->get($config['dotuser']['user_details_mapper']) : 
                                    $serviceLocator->get('DotUser\Mapper\UserDetailsDbMapper');
        
        
        $mapper = new UserDbMapper($userDetailsMapper);
        
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype($userEntity)
               ->setHydrator($userHydrator);
        
        return $mapper;
    }
}