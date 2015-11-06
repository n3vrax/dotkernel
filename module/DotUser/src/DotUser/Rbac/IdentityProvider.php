<?php

namespace DotUser\Rbac;

use ZfcRbac\Identity\IdentityProviderInterface;
use Zend\Authentication\AuthenticationService;

class IdentityProvider implements IdentityProviderInterface
{
    protected $rbacIdentity = null;
    
    protected $authenticationProvider;
    
    public function setAuthenticationProvider(AuthenticationService $authenticationProvider)
    {
        $this->authenticationProvider = $authenticationProvider;
        return $this;
    }
    
    
    public function getIdentity()
    {
        if($this->rbacIdentity === null)
        {
            $this->rbacIdentity = new Identity();
            
            $mvcIdentity = $this->authenticationProvider->getIdentity();
            $role = $mvcIdentity->getRoleId();
            
            $this->rbacIdentity->setRoles($role);
        }
        
        return $this->rbacIdentity;
        
    }

    
}