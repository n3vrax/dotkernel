<?php

namespace DotUser\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class UserMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options Options\ModuleOptions */
        $options = $serviceLocator->get('zfcuser_module_options');

        /* @var $dbAdapter Db\Adapter\Adapter */
        $dbAdapter = $serviceLocator->get('zfcuser_zend_db_adapter');

        $mapper = new \DotUser\Mapper\User();
        $mapper->setDbAdapter($dbAdapter);

        $entityClass = $options->getUserEntityClass();

        /* @var $hydrator Hydrator\HydratorInterface */
        $hydrator = $serviceLocator->get('zfcuser_user_hydrator');
        
        $mapper
        ->setEntityPrototype(new $entityClass)
        ->setHydrator($hydrator)
        ->setTableName($options->getTableName())
        ;

        return $mapper;
    }
}