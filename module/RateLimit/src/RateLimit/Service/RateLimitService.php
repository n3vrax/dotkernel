<?php

namespace RateLimit\Service;

use Perimeter\RateLimiter\Throttler\RedisThrottler;
class RateLimitService
{
    protected $throttlers = array();
    
    protected $packageLimits;
    
    protected $routeLimits;
    
    protected $controllerLimits;
    
    protected $restLimits;
    
    
    public function __construct(array $config)
    {
        if(!isset($config['throttlers']) || empty($config['throttlers']))
            return;
        
        foreach($config['throttlers'] as $name => $throttlerConfig)
        {
            switch($throttlerConfig['options']['type'])
            {
                default:
                case 'redis':
                    $redis = new \Predis\Client();
                    $throttler = new RedisThrottler($redis, $throttlerConfig['options']);
                break;
                case 'doctrine':
                    //TODO: initialize doctrine throttler
                    $throttler = null;
                break;
            }
            
            if($throttler !== null)
                $this->throttlers[$name] = $throttler;
        }
    }
    
    public function consume($meterId, $warnThreshold, $limitThreshold, $throttlers = array())
    {
        foreach ($throttlers as $throttlerName)
        {
            if(isset($this->throttlers[$throttlerName]))
                $this->throttlers[$throttlerName]->consume($meterId, $warnThreshold, $limitThreshold);
        }
    }
    
    public function isLimitWarning()
    {
        $result = false;
        foreach ($this->throttlers as $throttler)
        {
            $result = $throttler->isLimitWarning();
            if($result) break;
        }
        
        return $result;
    }
    
    public function isLimitExceeded()
    {
        $result = false;
        foreach ($this->throttlers as $throttler)
        {
            $result = $throttler->isLimitExceeded();
            if($result) break;
        }
        
        return $result;
    }
}