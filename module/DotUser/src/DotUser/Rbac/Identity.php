<?php

namespace DotUser\Rbac;

use ZfcRbac\Identity\IdentityInterface;

class Identity implements IdentityInterface
{
    protected $roles = array();
    
    public function setRoles($roles)
    {
        if(!is_array($roles)){
            $roles = array($roles);
        }
        
        $this->roles = $roles;
        return $this;
    }
    
    public function getRoles()
    {
        return $this->roles;
    }

    
}