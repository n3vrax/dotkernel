<?php

namespace DotUser\Factory\Authorization;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use DotUser\Listener\AuthorizationListener;

class AuthorizationListenerFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        if (!$services->has('DotUser\Rbac\AuthorizationInterface')) {
            throw new ServiceNotCreatedException(
                'Cannot create AuthorizationListener service; '
                . 'no DotUser\Rbac\AuthorizationInterfacee service available!'
            );
        }
        
        return new AuthorizationListener(
            $services->get('DotUser\Rbac\AuthorizationInterface')
        );
    }
}