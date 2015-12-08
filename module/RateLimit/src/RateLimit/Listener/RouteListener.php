<?php

namespace RateLimit\Listener;

use Zend\Mvc\MvcEvent;
use RateLimit\Service\RateLimitService;
use Zend\EventManager\EventManagerInterface;
use RateLimit\MvcLimitEvent;
use Zend\Http\Response;
class RouteListener
{
    protected $rateLimitService;
    
    protected $eventManager;
    
    protected $mvcLimitEvent;
    
    public function __construct(RateLimitService $rateLimitService, 
        EventManagerInterface $eventManager,
        MvcLimitEvent $mvcLimitEvent
        )
    {
        $this->rateLimitService = $rateLimitService;
        $this->eventManager = $eventManager;
        $this->mvcLimitEvent = $mvcLimitEvent;
    }
    
    public function setEventManager(EventManagerInterface $ev)
    {
        $this->eventManager = $ev;
        return $this;
    }
    
    public function getEventManager()
    {
        return $this->eventManager;
    }
    
    public function __invoke(MvcEvent $e)
    {
        $response = $e->getResponse();
        $this->rateLimitService->consume($e->getRouteMatch(), $e->getRequest());
        
        //var_dump($this->rateLimitService->getTopMeters('daily_limits'));exit;
        
        if($this->rateLimitService->isLimitExceeded())
        {
            //trigger the ratelimit exceeded event
            $mvcLimitEvent = $this->mvcLimitEvent;
            $response = $this->eventManager->trigger(MvcLimitEvent::EVENT_RATELIMIT_EXCEEDED, $mvcLimitEvent, function($r){
                return $r instanceof Response;
            });
            
            $response = $response->last();
            
            return $response;
        }
        elseif($this->rateLimitService->isLimitWarning())
        {
            //trigger the ratelimit warning event
            $mvcLimitEvent = $this->mvcLimitEvent;
            $response = $this->eventManager->trigger(MvcLimitEvent::EVENT_RATELIMIT_WARN, $mvcLimitEvent, function($r){
                return $r instanceof Response;
            });
        
                $response = $response->last();
                $e->setResponse($response);
        }
    }
}