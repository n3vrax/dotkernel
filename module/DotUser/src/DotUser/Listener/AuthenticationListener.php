<?php

namespace DotUser\Listener;

use ZF\MvcAuth\MvcAuthEvent;
use ZF\MvcAuth\Authentication\DefaultAuthenticationListener;
use DotUser\Service\UserServiceInterface;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use DotBase\Mapper\RestMapperInterface;


class AuthenticationListener extends DefaultAuthenticationListener
{
    protected $userService;
    
    protected $userHydrator;
    
    protected $oauthClientMapper;
    
    public function __construct(UserServiceInterface $userService, HydratorInterface $userHydrator, RestMapperInterface $oauthClientMapper)
    {
        $this->userService = $userService;
        $this->userHydrator = $userHydrator;
        $this->oauthClientMapper = $oauthClientMapper;
    }
    
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = parent::__invoke($mvcAuthEvent);
        $authIdentity = array();
        if($identity instanceof AuthenticatedIdentity)
        {
            //get user details
            $authIdentity = $identity->getAuthenticationIdentity();
            if(isset($authIdentity['user_id']))
            {
                $user = $this->userService->findUserByUsername($authIdentity['user_id']);
                $user->addHydratorFilter("details", new MethodMatchFilter("getDetails"), FilterComposite::CONDITION_AND);
                
                $userArray = $this->userHydrator->extract($user);
                
                $authIdentity['user_data'] = $userArray;
                
            }
            
            //get oauth client details
            if(isset($authIdentity['client_id']))
            {
                $client = $this->oauthClientMapper->fetchEntity($authIdentity['client_id']);
                if($client)
                {
                    $authIdentity['client_data'] = $this->oauthClientMapper->getHydrator()->extract($client);
                    
                }
            }
            
            $identity = new AuthenticatedIdentity($authIdentity);
            $identity->setName($authIdentity['user_data']['roleId']);
        }
        
        var_dump($identity);exit;
        return $identity;
    }
}