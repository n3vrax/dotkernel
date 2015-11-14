<?php
namespace UserApi\V1\Rest\Role;

class RoleResourceFactory
{
    public function __invoke($services)
    {
        $mapper = $services->get('DotUser\\Mapper\\UserRoleDbMapper');
        
        return new RoleResource($mapper);
    }
}
