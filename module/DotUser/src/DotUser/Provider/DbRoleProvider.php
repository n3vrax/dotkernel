<?php

namespace DotUser\Provider;

use ZfcRbac\Role\RoleProviderInterface;
use DotBase\Mapper\RestMapperInterface;

class DbRoleProvider implements RoleProviderInterface
{
    protected $roleMapper;
    
    protected $roleCache = array();
    
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
        //TODO: get role hierarchy
        
    }

    
}