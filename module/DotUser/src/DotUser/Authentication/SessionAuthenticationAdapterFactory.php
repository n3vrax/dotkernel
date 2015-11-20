<?php

namespace DotUser\Authentication;

use Zend\ServiceManager\ServiceLocatorInterface;
class SessionAuthenticationAdapterFactory
{
    public function __invoke(ServiceLocatorInterface $services )
    {
        $config = $services->get('config');
        $userMapper = isset($config['dotuser']['user_mapper']) && !empty($config['dotuser']) ? 
                        $services->get($config['dotuser']['user_mapper']) : 
                        $services->get('DotUser\Mapper\UserDbMapper');
        
        return new SessionAuthenticationAdapter($userMapper, $config);
    }
}