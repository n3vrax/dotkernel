<?php

namespace DotUser\Rbac;

use Zend\ServiceManager\ServiceLocatorInterface;

class IdentityProviderFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        $authenticationProvider = $services->get('authentication');
        
        $identityProvider = new IdentityProvider();
        $identityProvider->setAuthenticationProvider($authenticationProvider);
        return $identityProvider;
    }
}