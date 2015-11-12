<?php

namespace DotUser\Entity;


class UserRoleEntity
{ 
    protected $roleId;
    
    protected $isDefault;
    
    protected $scopes;

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
        return $this;
    }
    
    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
        return $this;
    }
    
    public function getIsDefault()
    {

        
    }
    public function getScopes()
    {
        return $this->scopes;
    }

    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }

    
    
}