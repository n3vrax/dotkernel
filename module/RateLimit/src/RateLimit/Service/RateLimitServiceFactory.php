<?php

namespace RateLimit\Service;

class RateLimitServiceFactory
{
    public function __invoke($services)
    {
        $config = $services->get('config');
        
        return new RateLimitService($config);
    }
}