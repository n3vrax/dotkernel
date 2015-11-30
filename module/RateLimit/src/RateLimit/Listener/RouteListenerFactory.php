<?php

namespace RateLimit\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
class RouteListenerFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        $rateLimitService = $services->get('RateLimit\Service\RateLimitService');
        
        return new RouteListener($rateLimitService);
    }
}