<?php

namespace DotLimit;

use Zend\Cache\Storage\Event;
use Zend\Mvc\MvcEvent;
class MvcLimitEvent extends Event
{
    const EVENT_RATELIMIT_WARN = 'ratelimit.warn';
    const EVENT_RATELIMIT_EXCEEDED = 'ratelimit.exceeded';
    
    protected $mvcEvent;
    
    protected $limitService;
    
    public function __construct(MvcEvent $mvcEvent, $limitService)
    {
        $this->mvcEvent = $mvcEvent;
        $this->limitService = $limitService;
    }
    
    public function setMvcEvent(MvcEvent $event)
    {
        $this->mvcEvent = $event;
        return $this;
    }
    
    public function getMvcEvent()
    {
        return $this->mvcEvent;
    }
    
    public function setLimitService($limitService)
    {
        $this->limitService = $limitService;
        return $this;
    }
    
    public function getLimitService()
    {
        return $this->limitService;
    }
}