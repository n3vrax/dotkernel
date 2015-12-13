<?php

namespace DotLimit;

use Zend\Cache\Storage\Event;
use Zend\Mvc\MvcEvent;
class MvcLimitEvent extends Event
{
    const EVENT_RATELIMIT_WARN = 'ratelimit.warn';
    const EVENT_RATELIMIT_EXCEEDED = 'ratelimit.exceeded';
    
    protected $mvcEvent;
    
    public function __construct(MvcEvent $mvcEvent)
    {
        $this->mvcEvent = $mvcEvent;
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
}