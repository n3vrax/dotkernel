<?php

namespace DotUser\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Service\UserService;

class UserServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userService = new UserService();
        
        $userMapper = $serviceLocator->get('dotuser_user_mapper');
        $userDetailsMapper = $serviceLocator->get('dotuser_user_details_mapper');
        
        $userService->setUserDetailsMapper($userDetailsMapper);
        $userService->setUserMapper($userMapper);
        
        return $userService;
    }
}