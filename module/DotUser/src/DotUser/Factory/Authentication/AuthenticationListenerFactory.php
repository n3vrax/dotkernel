<?php

namespace DotUser\Factory\Authentication;

use ZF\MvcAuth\Factory\DefaultAuthenticationListenerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Listener\AuthenticationListener;

class AuthenticationListenerFactory extends DefaultAuthenticationListenerFactory
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');
        
        if(!isset($config['dotuser']['user_service']) || empty($config['dotuser']['user_service']))
        {
            throw new \Exception('no UserService defined for key `user_service`');
        }
        $userService = $services->get($config['dotuser']['user_service']);
        
        $userHydrator = isset($config['dotuser']['user_hydrator']) && !empty($config['dotuser']['user_hydrator']) ?
            $services->get('HydratorManager')->get($config['dotuser']['user_hydrator']) :
            $services->get('HydratorManager')->get('DotUser\Entity\UserHydrator');
        
        $oauthClientMapper = $services->get('DotUser\Mapper\OauthClientDbMapper');
        
        $listener = new AuthenticationListener($userService, $userHydrator, $oauthClientMapper);
        
        $httpAdapter = $this->retrieveHttpAdapter($services);
        if ($httpAdapter) {
            $listener->attach($httpAdapter);
        }
        
        $oauth2Server = $this->createOAuth2Server($services);
        if ($oauth2Server) {
            $listener->attach($oauth2Server);
        }
        
        $authenticationTypes = $this->getAuthenticationTypes($services);
        if ($authenticationTypes) {
            $listener->addAuthenticationTypes($authenticationTypes);
        }
        
        $listener->setAuthMap($this->getAuthenticationMap($services));
        
        return $listener;
    }
    
}