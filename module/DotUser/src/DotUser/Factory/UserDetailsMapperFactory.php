<?php

namespace DotUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserDetails;

class UserDetailsMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options Options\ModuleOptions */
        $options = $serviceLocator->get('zfcuser_module_options');
        
        /* @var $dbAdapter Db\Adapter\Adapter */
        $dbAdapter = $serviceLocator->get('zfcuser_zend_db_adapter');
        
        $mapper = new \DotUser\Mapper\UserDetails();
        $mapper->setDbAdapter($dbAdapter);
        
        /* @var $hydrator Hydrator\HydratorInterface */
        $hydrator = $serviceLocator->get('dotuser_user_details_hydrator');
        
        $mapper
        ->setEntityPrototype(new UserDetails())
        ->setHydrator($hydrator)
        ->setTableName('user_details')
        ;
        
        return $mapper;
    }
}