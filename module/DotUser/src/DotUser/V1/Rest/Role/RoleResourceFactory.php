<?php
namespace DotUser\V1\Rest\Role;

class RoleResourceFactory
{
    public function __invoke($services)
    {
        return new RoleResource();
    }
}
