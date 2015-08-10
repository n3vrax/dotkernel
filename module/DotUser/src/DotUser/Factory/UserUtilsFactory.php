<?php

namespace DotUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use DotUser\Helper\UserUtils;

class UserUtilsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userTokenTable = new TableGateway('user_token', $serviceLocator->get('Zend\Db\Adapter\Adapter'));
        
        $class = new UserUtils($userTokenTable);
        $class->setServiceLocator($serviceLocator);
        
        return $class;
    }
}