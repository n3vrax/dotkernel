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
        
        $config = $serviceLocator->get('Config');
        $userMapper = isset($config['dotuser']['user_mapper']) && !empty($config['dotuser']) ? 
                        $serviceLocator->get($config['dotuser']['user_mapper']) : 
                        $serviceLocator->get('DotUser\Mapper\UserDbMapper');
        
        $userService->setUserMapper($userMapper);
        
        return $userService;
    }
}