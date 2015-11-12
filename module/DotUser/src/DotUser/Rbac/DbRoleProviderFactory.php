<?php

namespace DotUser\Rbac;

use Zend\ServiceManager\ServiceLocatorInterface;

class DbRoleProviderFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        $services = $services->getServiceLocator();
        
        $roleMapper = $services->get('DotUser\Mapper\UserRoleDbMapper');
        
        $authenticationService = $services->get('authentication');
        
        $roleProvider = new DbRoleProvider($roleMapper, $authenticationService);
        
        
        return $roleProvider;
    }
}