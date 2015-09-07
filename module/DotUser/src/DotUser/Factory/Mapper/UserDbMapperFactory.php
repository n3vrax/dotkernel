<?php

namespace DotUser\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Mapper\UserDbMapper;

class UserDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('zfcuser_module_options');
        $dbAdapter = $serviceLocator->get('zfcuser_zend_db_adapter');
        
        $entity = $options->getUserEntityClass();
        $hydrator = $serviceLocator->get('zfcuser_user_hydrator');
        
        $mapper = new UserDbMapper();
        
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype(new $entity)
               ->setHydrator($hydrator)
               ->setTableName($options->getTableName());
        
        return $mapper;
    }
}