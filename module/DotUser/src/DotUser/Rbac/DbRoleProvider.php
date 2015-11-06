<?php

namespace DotUser\Rbac;

use ZfcRbac\Role\RoleProviderInterface;
use DotBase\Mapper\RestMapperInterface;
use Rbac\Role\Role;

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
        $roles = $this->roleMapper->fetchAllEntities();
        $out = array();
        
        foreach($roleNames as $roleName)
        {
            foreach ($roles as $role)
            {
                if($role->getRoleId() === $roleName){
                    $out[] = new Role($roleName);
                    
                    //TODO: get role permissions
                    
                }
            }
        }
        
        return $out;
    }

    
}