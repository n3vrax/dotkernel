<?php

namespace RateLimit;

class UserPackageNameProviderFactory
{
    public function __invoke($services)
    {
        if ($services->has('Zend\Authentication\AuthenticationService')) {
            return new UserPackageNameProvider(
                $services->get('Zend\Authentication\AuthenticationService')
            );
        }
        
        return new UserPackageNameProvider(null);
    }
}