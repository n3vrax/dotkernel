<?php

namespace DotUser\Entity;

use Rbac\Role\HierarchicalRole;
use Zend\Stdlib\Hydrator\Filter\FilterProviderInterface;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\GetFilter;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;

class UserRoleEntity
{ 
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

    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
        return $this;
    }
    
    public function getIsDefault()
    {
        return $this->isDefault;
    }
    
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }
    
    public function getParentId()
    {
        return $this->parentId;
    }
    
}