<?php

namespace RateLimit\Service;

use Perimeter\RateLimiter\Throttler\RedisThrottler;
use RateLimit\LimitsNode;
use RateLimit\RateLimit;
class RateLimitServiceFactory
{
    public function __invoke($services)
    {
        $config = $services->get('config');
        if(!isset($config['rate_limit']))
            throw new \Exception('no throttlers defined in the config. This is required if using RateLimit module');
        
        $config = $config['rate_limit'];
        
        $throttlers = array();
        $limits = array();
        
        if(isset($config['throttlers']) && !empty($config['throttlers']))
        {
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
                    $throttlers[$name] = $throttler;
            }    
        }
        
        if(isset($config['limits']) && !empty($config['limits']))
            $this->processLimits('dotlimit', $config['limits'], $limits);
        
        
        return new RateLimitService($throttlers, $limits);
    }
    
    
    public function processLimits($prefix, $config, &$limits)
    {
        $node = $this->getLimitsNode($prefix, $config);
        if($node !== null)
            $limits[$prefix] = $node;
        
        $packageLimits = $this->processPackageLimits($prefix, $config);
        $limits = array_merge($limits, $packageLimits);
        
        foreach($config as $n => $c)
        {
            if($n === 'warn_threshold' || $n === 'limit_threshold' || $n === 'package_limits')
                continue;
            
            $this->processLimits($prefix . ':' . $n, $c, $limits);
        }
        
    }
    
    
    public function processPackageLimits($prefix, $config)
    {
        $limits = array();
        if(isset($config['package_limits']) && is_array($config['package_limits']))
        {
            foreach($config['package_limits'] as $packageName => $values)
            {
                $packagePrefix = $prefix . '::' . $packageName;
                $node = $this->getLimitsNode($packagePrefix, $values);
                if(null !== $node)
                    $limits[$packagePrefix] = $node;
            }
        }
        
        return $limits;
    }
    
    public function getLimitsNode($prefix, $config)
    {
        $warnThresholds = array();
        $limitThresholds = array();
        
        if(isset($config['warn_threshold']) && is_array($config['warn_threshold']))
        {
            foreach ($config['warn_threshold'] as $throttlerName => $limit)
            {
                $warnThresholds[$throttlerName] = $limit;
            }
        }
        
        if(isset($config['limit_threshold']) && is_array($config['limit_threshold']))
        {
            foreach ($config['limit_threshold'] as $throttlerName => $limit)
            {
                $limitThresholds[$throttlerName] = $limit;
            }
        }
        
        if(!empty($warnThresholds) && !empty($limitThresholds))
            return new LimitsNode($prefix, $warnThresholds, $limitThresholds);
        
        return null;
    }
}