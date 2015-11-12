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
        $isGranted = $this->authorizationService->isGranted('get_user');
        //TODO: check permissions
        return true;
    }
}