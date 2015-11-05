<?php

namespace DotUser\Factory\Provider;

use DotUser\Provider\DbRoleProvider;

class DbRoleProviderFactory
{
    public function __invoke($services)
    {
        $roleMapper = $services->get('DotUser\\Mapper\\UserRoleDbMapper');
        
        $roleProvider = new DbRoleProvider($roleMapper);
        
        return $roleProvider;
    }
}