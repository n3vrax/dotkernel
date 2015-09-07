<?php

namespace DotUser\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Mapper\UserDetailsDbMapper;
use DotUser\Entity\UserDetailsEntity;
use DotUser\Entity\UserDetailsHydrator;

class UserDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {   
        $options = $serviceLocator->get('zfcuser_module_options');
        
        $dbAdapter = $serviceLocator->get('zfcuser_zend_db_adapter');
        
        $mapper = new UserDetailsDbMapper();
        
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype(new UserDetailsEntity())
               ->setHydrator(new UserDetailsHydrator());
        
        return $mapper;
    }
}