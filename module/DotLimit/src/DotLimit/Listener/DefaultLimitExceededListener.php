<?php

namespace DotLimit\Listener;

use DotLimit\MvcLimitEvent;
class DefaultLimitExceededListener
{
    public function __invoke(MvcLimitEvent $event)
    {
        $mvcEvent = $event->getMvcEvent();
        $response = $mvcEvent->getResponse();
        
        $response->setStatusCode(429);
        $response->setReasonPhrase('Too Many Requests');
        
        $headers = $response->getHeaders();
        $headers->addHeaderLine('X-Ratelimit-Error', 'you have reached the request limit');
        $response->setHeaders($headers);
        
        return $response;
    }
}