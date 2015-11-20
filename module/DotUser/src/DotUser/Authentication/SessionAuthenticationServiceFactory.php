<?php

namespace DotUser\Authentication;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class SessionAuthenticationServiceFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        $adapter = $services->get('session_auth_adapter');
        
        return new AuthenticationService(new Session("session_auth"), $adapter);
    }
}