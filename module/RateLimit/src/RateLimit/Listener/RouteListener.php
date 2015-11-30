<?php

namespace RateLimit\Listener;

use Zend\Mvc\MvcEvent;
use RateLimit\Service\RateLimitService;
class RouteListener
{
    protected $rateLimitService;
    
    public function __construct(RateLimitService $rateLimitService)
    {
        $this->rateLimitService = $rateLimitService;
    }
    
    public function __invoke(MvcEvent $e)
    {
        
    }
}