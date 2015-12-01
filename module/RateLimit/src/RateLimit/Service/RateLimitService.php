<?php

namespace RateLimit\Service;


class RateLimitService
{
    protected $throttlers = array();
    
    protected $limits = array();
    
    public function __construct(array $throttlers, array $limits)
    {
        $this->throttlers = $throttlers;
        $this->limits = $limits;
    }
    
    public function consume($meterId)
    {
        $node = $this->getClosestMeterIdMatch($meterId);
        var_dump($node);exit;
        foreach ($this->throttlers as $throttlerName)
        {
            $warnThreshold = $node->getWarnThreshold($throttlerName);
            $limitThreshold = $node->getLimitThreshold($throttlerName);
            
            if(isset($this->throttlers[$throttlerName]) && $warnThreshold !== null && $limitThreshold !== null)
                $this->throttlers[$throttlerName]->consume($node->getKey(), $warnThreshold, $limitThreshold);
        }
    }
    
    protected function getClosestMeterIdMatch($meterId)
    {
        $parts = explode('::', $meterId);
        $m = $parts[0];
        $p = isset($parts[1]) ? $parts[1] : '';
        
        $parts = explode(':', $m);
        
        $s = implode(':', $parts);
        while($s !== '')
        {
            if(!empty($p)){
                $withPackage = $s . '::' . $p;
                if(isset($this->limits[$withPackage]))
                    return $this->limits[$withPackage];
            }
            
            if(isset($this->limits[$s]))
                return $this->limits[$s];
            
            array_pop($parts);
            $s = implode(':', $parts);
            
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