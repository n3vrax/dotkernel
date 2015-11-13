<?php

namespace DotUser\Rbac;

use ZF\MvcAuth\Authorization\AuthorizationInterface;
use ZF\MvcAuth\Identity\IdentityInterface;
use ZfcRbac\Service\AuthorizationService;

class Authorization implements AuthorizationInterface
{
    protected $authorizationService;
    
    protected $config;
    
    public function setAuthorizationService(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }
    
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
    
    
    public function isAuthorized(IdentityInterface $identity, $resource, $privilege)
    {
        $restGuard = $this->config['rest_guards'];
        list($controller, $group) = explode('::', $resource);
        if(isset($restGuard[$controller][$group][$privilege])) 
        {
            $result = $restGuard[$controller][$group][$privilege];
            if(is_array($result))
            {
                $and = true;
                foreach ($result as $r)
                {
                    $and = $and && $this->authorizationService->isGranted($r);
                }
                $result = $and;
            }
            return $result;
        }
        
        return true;
    }
}