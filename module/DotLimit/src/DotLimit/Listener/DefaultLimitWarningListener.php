<?php

namespace DotLimit\Listener;

use DotLimit\MvcLimitEvent;
class DefaultLimitWarningListener
{
    public function __invoke(MvcLimitEvent $event)
    {
        $mvcEvent = $event->getMvcEvent();
        $limitService = $event->getLimitService();
        $response = $mvcEvent->getResponse();
        
        $headers = $response->getHeaders();
        $headers->addHeaderLine('X-RateLimit-Warning', 'You are running out of requests. Slow Down!');
        $response->setHeaders($headers);
        
        return $response;
    }
}