<?php

namespace DotUser\Rbac;

use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorizationFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        $authorizationService = $services->get('ZfcRbac\Service\AuthorizationService');
        
        $config = $services->get('config');
        $rbacConfig = $config['zfc_rbac'];
        $authorization = new Authorization();
        $authorization->setConfig($rbacConfig);
        $authorization->setAuthorizationService($authorizationService);
        return $authorization;
    }
}