<?php

namespace DotUser\Listener;

use ZF\MvcAuth\MvcAuthEvent;
use ZF\MvcAuth\Authentication\DefaultAuthenticationListener;
use DotUser\Service\UserServiceInterface;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\ArrayUtils;

class AuthenticationListener extends DefaultAuthenticationListener
{
    protected $userService;
    
    protected $userHydrator;
    
    public function __construct(UserServiceInterface $userService, HydratorInterface $userHydrator)
    {
        $this->userService = $userService;
        $this->userHydrator = $userHydrator;
    }
    
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = parent::__invoke($mvcAuthEvent);
        
        if($identity instanceof AuthenticatedIdentity)
        {
            $authenticationIdentity = $identity->getAuthenticationIdentity();
            if(isset($authenticationIdentity['user_id']))
            {
                $user = $this->userService->findUserByUsername($authenticationIdentity['user_id']);
                $userArray = $this->userHydrator->extract($user);
                
                $authenticationIdentity = ArrayUtils::merge($userArray, $authenticationIdentity);
                $identity = new AuthenticatedIdentity($authenticationIdentity);
                $identity->setName($authenticationIdentity['user_id']);
            }
        }
        
        //var_dump($identity);exit;
        return $identity;
    }
}