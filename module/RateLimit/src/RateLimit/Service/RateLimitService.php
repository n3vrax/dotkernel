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
        
        if($node === null) return;
        
        foreach ($this->throttlers as $throttlerName => $throttler)
        {
            $warnThreshold = $node->getWarnThreshold($throttlerName);
            $limitThreshold = $node->getLimitThreshold($throttlerName);
            
            //if threshold are missing for this throttler or are set to 0 we dont rate limit the meterId
            
            if($warnThreshold !== null && $limitThreshold !== null && $warnThreshold !== 0 && $limitThreshold != 0)
                $throttler->consume($meterId . '-' . $throttlerName, $warnThreshold, $limitThreshold);
        }
    }
    
    protected function getClosestMeterIdMatch($meterId)
    {
        //dotlimit:<controller_name>:<action_name>:<method>::<package>#<token>
        
        //token removal
        $parts = explode('#', $meterId);
        $meterId = $parts[0];
        
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
        
        return null;
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
    
    public function getTopMeters($throttlerName)
    {
        if(isset($this->throttlers[$throttlerName]))
            return $this->throttlers[$throttlerName]->getTopMeters();
    }
}