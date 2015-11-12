<?php

namespace DotUser\Rbac;

use ZfcRbac\Role\RoleProviderInterface;
use DotBase\Mapper\RestMapperInterface;
use Rbac\Role\Role;
use Zend\Authentication\AuthenticationService;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;

class DbRoleProvider implements RoleProviderInterface
{
    protected $roleMapper;
    
    protected $authenticationService;
    
    protected $roleCache = array();
    
    public function __construct(RestMapperInterface $roleMapper, AuthenticationService $authenticationService)
    {
        $this->roleMapper = $roleMapper;
        $this->authenticationService = $authenticationService;
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
    
    public function clearRoleCache()
    {
        $this->roleCache = [];
    }
    
    public function getRoles(array $roleNames)
    {
        $identity = $this->authenticationService->getIdentity();
        $authenticatedIdentity = [];
        $keypart = 'guest';
        if($identity instanceof AuthenticatedIdentity){
            $authenticatedIdentity = $identity->getAuthenticationIdentity();
            $keypart = $authenticatedIdentity['client_id'] . $authenticatedIdentity['access_token'];
        }
        
        $key = implode('_', array(implode('', $roleNames), $keypart));
        if(isset($this->roleCache[$key]))
        {
            return $this->roleCache[$key];
        }
        
        $roles = [];
        
        foreach ($roleNames as $roleName)
        {
            $roleEntity = $this->roleMapper->fetchEntity($roleName);
            if(!$roleEntity){
                $roles[] = new Role($roleName);
                continue;
            }
            
            $role = new Role($roleName);
            
            $permissions = $roleEntity->getScopes();
            if(!empty($permissions))
                $permissions = explode(' ', $permissions);
            
            
            $client_permissions = $permissions;
            if(isset($authenticatedIdentity['client_data']))
            {
                if(isset($authenticatedIdentity['client_data']['scope']) && 
                    !empty($authenticatedIdentity['client_data']['scope']))
                {
                    $client_permissions = explode(' ', $authenticatedIdentity['client_data']['scope']);
                }
            }
            
            $token_permissions = $permissions;
            if(isset($authenticatedIdentity['scope']) && !empty($authenticatedIdentity['scope'])){
                $token_permissions = explode(' ', $authenticatedIdentity['scope']);
            }
            
            $permissions = array_intersect($permissions, $client_permissions, $token_permissions);
            
            foreach ($permissions as $permission){
                $role->addPermission($permission);
            }
            
            $roles[] = $role;
        }
        
        
        $this->roleCache[$key] = $roles;
        
        return $roles;
        
    }

    
}