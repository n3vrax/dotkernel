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
        $request = $e->getRequest();
        
        //$this->rateLimitService->consume('dotlimit:UserApi\V1\Rest\User\Controller:entity:PATCH::enterprise');
    }
}