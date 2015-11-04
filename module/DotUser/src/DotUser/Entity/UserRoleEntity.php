<?php

namespace DotUser\Entity;

use Zend\Permissions\Acl\Role\RoleInterface;

class UserRoleEntity implements RoleInterface
{
    protected $id;
    
    protected $roleId;
    
    protected $isDefault;
    
    protected $parentId;

    
    
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
        return $this;
    }
    
    public function getRoleId()
    {
        return $this->roleId;
    }

    
    
    
    
}