<?php

namespace RateLimit;

class UserPackageNameProviderFactory
{
    public function __invoke($services)
    {
        $authentication = null;
        
        if ($services->has('authentication')) {
            $authentication = $services->get('authentication');
        }
        
        if($authentication === null){
            if($services->has('Zend\Atuhentication\AuthenticationService'))
            {
                $authentication = $services->get('Zend\Atuhentication\AuthenticationService');
            }
        }
        
        return new UserPackageNameProvider($authentication);
    }
}