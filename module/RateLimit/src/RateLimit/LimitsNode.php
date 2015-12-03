<?php

namespace RateLimit;

class LimitsNode
{
    protected $key;
    
    protected $warnThresholds = [];
    
    protected $limitThresholds = [];
    
    public function __construct($key = null, array $warnThresholds = array(), array $limitThresholds = array())
    {
        $this->key = $key;
        $this->warnThresholds = $warnThresholds;
        $this->limitThresholds = $limitThresholds;
    }
    
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
    
    public function getKey()
    {
        return $this->key;
    }
    
    public function setWarnThresholds(array $warnThresholds)
    {
        $this->warnThresholds = $warnThresholds;
        return $this;
    }
    
    public function getWarnThresholds()
    {
        return $this->warnThresholds;
    }
    
    public function setLimitThresholds(array $limitThreshold)
    {
        $this->limitThresholds = $limitThreshold;
        return $this;
    }
    
    public function getLimitThresholds()
    {
        return $this->limitThresholds;
    }
    
    public function addWarnThreshold($key, $value)
    {
        $this->warnThresholds[$key] = $value;
        return $this;
    }
    
    public function getWarnThreshold($key)
    {
        return isset($this->warnThresholds[$key]) ? $this->warnThresholds[$key] : null;
    }
    
    public function addLimitThreshold($key, $value)
    {
        $this->limitThresholds[$key] = $value;
        return $this;
    }
    
    public function getLimitThreshold($key)
    {
        return isset($this->limitThresholds[$key]) ? $this->limitThresholds[$key] : null;
    }
}