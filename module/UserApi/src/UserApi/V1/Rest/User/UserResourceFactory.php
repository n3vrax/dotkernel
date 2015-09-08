<?php
namespace UserApi\V1\Rest\User;

class UserResourceFactory
{
    public function __invoke($services)
    {
        $userMapper = $services->get('dotuser_user_mapper');
        
        return new UserResource($userMapper);
    }
}
