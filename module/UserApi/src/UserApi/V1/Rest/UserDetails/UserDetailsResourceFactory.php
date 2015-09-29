<?php
namespace UserApi\V1\Rest\UserDetails;

class UserDetailsResourceFactory
{
    public function __invoke($services)
    {
        $mapper = $services->get('DotUser\Mapper\UserDetailsDbMapper');
        
        return new UserDetailsResource($mapper);
    }
}
