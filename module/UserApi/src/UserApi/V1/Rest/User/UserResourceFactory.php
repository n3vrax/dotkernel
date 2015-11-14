<?php
namespace UserApi\V1\Rest\User;

class UserResourceFactory
{
    public function __invoke($services)
    {
        $config = $services->get('Config');
        
        if(!isset($config['dotuser']['user_service']) || empty($config['dotuser']['user_service']))
        {
            throw new \Exception('no UserService defined for key `user_service`');
        }
        $userService = $services->get($config['dotuser']['user_service']);
        
        return new UserResource($userService);
    }
}
