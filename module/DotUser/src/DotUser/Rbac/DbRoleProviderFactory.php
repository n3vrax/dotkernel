<?php

namespace DotUser\Rbac;

class DbRoleProviderFactory
{
    public function __invoke($services)
    {
        $roleMapper = $services->get('DotUser\Mapper\UserRoleDbMapper');
        
        $roleProvider = new DbRoleProvider($roleMapper);
        
        return $roleProvider;
    }
}