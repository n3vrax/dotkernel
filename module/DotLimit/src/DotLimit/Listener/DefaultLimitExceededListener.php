<?php

namespace DotLimit\Listener;

use DotLimit\MvcLimitEvent;
class DefaultLimitExceededListener
{
    public function __invoke(MvcLimitEvent $event)
    {
        $mvcEvent = $event->getMvcEvent();
        $response = $mvcEvent->getResponse();
        $limitService = $event->getLimitService();
        
        //change responses status code to reflect limit exceeded
        $response->setStatusCode(429);
        $response->setReasonPhrase('Too Many Requests');
        
        return $response;
    }
}