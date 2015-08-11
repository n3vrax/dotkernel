<?php

namespace DotMailTransporter\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotMailTransporter\Mapper\TransporterDbMapper;
use DotMailTransporter\Entity\TransporterEntity;
use DotMailTransporter\Entity\TransporterEntityHydrator;

class TransporterDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mapper = new TransporterDbMapper();
        
        $mapper->setDbAdapter($serviceLocator->get('database'));
        $mapper->setHydrator(new TransporterEntityHydrator());
        $mapper->setEntityPrototype(new TransporterEntity());
        
        return $mapper;
    }
}