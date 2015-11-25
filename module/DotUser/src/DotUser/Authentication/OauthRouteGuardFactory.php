<?php

namespace DotUser\Authentication;

class OauthRouteGuardFactory
{
    public function __invoke($services)
    {
        if(!$services->has('database'))
            throw new \Exception('no database adapter set for service key `database`');
        
        if(!$services->has('Zend\Authentication\AuthenticationService'))
            throw new \Exception('no authentication service available');
        
        $database = $services->get('database');
        $auth = $services->get('Zend\Authentication\AuthenticationService');
        $pdoAdapter = $services->get('DotBase\OAuth\Adapter\PdoAdapter');
        
        return new OauthRouteGuard($database, $auth, $pdoAdapter);
    }
}