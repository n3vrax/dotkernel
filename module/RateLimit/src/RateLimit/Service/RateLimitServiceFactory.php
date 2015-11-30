<?php

namespace RateLimit\Service;

class RateLimitServiceFactory
{
    public function __invoke($services)
    {
        $config = $services->get('config');
        if(!isset($config['rate_limit']))
            throw new \Exception('no throttlers defined in the config. This is required if using RateLimit module');
        
        return new RateLimitService($config['rate_limit']);
    }
}