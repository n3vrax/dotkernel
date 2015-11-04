<?php

namespace DotUser\Provider;

use ZfcRbac\Role\RoleProviderInterface;
use DotBase\Mapper\RestMapperInterface;

class RoleProvider implements RoleProviderInterface
{
    protected $roleMapper;
    
    public function __construct(RestMapperInterface $roleMapper)
    {
        $this->roleMapper = $roleMapper;
    }
    
    public function getRoleMapper()
    {
        return $this->roleMapper;
    }
    
    public function setRoleMapper(RestMapperInterface $roleMapper)
    {
        $this->roleMapper = $roleMapper;
        return $this;
    }
    
    public function getRoles(array $roleNames)
    {
        // TODO Auto-generated method stub
        
    }

    
}