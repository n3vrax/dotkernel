<?php

namespace DotLimit\Listener;

use DotLimit\MvcLimitEvent;
class DefaultLimitWarningListener
{
    public function __invoke(MvcLimitEvent $event)
    {
        $mvcEvent = $event->getMvcEvent();
        $response = $mvcEvent->getResponse();
        
        //add a warning rate limit header
        $headers = $response->getHeaders();
        $headers->addHeaderLine('X-Ratelimit-Warning', 'slow down the requests');
        $response->setHeaders($headers);
        
        return $response;
    }
}