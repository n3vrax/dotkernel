<?php

namespace DotUser\Entity;


class UserRoleEntity
{ 
    protected $roleId;
    
    protected $isDefault;
    

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
        return $this->isDefault;
    }
    
}