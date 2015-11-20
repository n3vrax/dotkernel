<?php

namespace DotUser\Controller;

class UserControllerFactory
{
    public function __invoke($controller_services)
    {
        $services = $controller_services->getServiceLocator();
        
        $authentication = $services->get('session_authentication');
        $loginForm = $services->get('DotUser\Form\LoginForm');
        
        $controller = new UserController($authentication);
        $controller->setLoginForm($loginForm);
        
        return $controller;
    }
}