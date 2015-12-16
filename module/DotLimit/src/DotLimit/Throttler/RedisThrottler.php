<?php

namespace DotLimit\Throttler;

class RedisThrottler extends \Perimeter\RateLimiter\Throttler\RedisThrottler
{
    //this is usefull for getting status about limits regarding a time window
    //works best with single buckets that count the number of requests made so far
    public function getLimitStatus($meterId, $limitThreshold)
    {
        $buckets = $this->getBuckets(null);
        
        if(empty($buckets)) return [];
        
        try{
            $key = sprintf('meter:%s:%d', $meterId, $buckets[0]);
            $value = $this->redis->get($key);
            
            $reset = $buckets[0] + ($this->config['bucket_size'] * $this->config['num_buckets']);
            $remaining = $limitThreshold - $value;
            if($remaining < 0) $remaining = 0;
            
            return ['limit' => $limitThreshold, 'remaining' => $remaining, 'reset' => $reset];
            
        }
        catch(\Exception $e)
        {
            if ($this->debug) {
                throw $e;
            }
        }
    }
    
    private function getBuckets($time = null)
    {
        $buckets = array();
    
        if (is_null($time)) {
            $time = time();
        }
    
        // create $config['num_buckets'] of $config['bucket_size'] seconds
        $buckets[0] = $time - ($time % $this->config['bucket_size']); // align to $config['bucket_size'] second boundaries
    
        for ($i=1; $i < $this->config['num_buckets']; $i++) {
            $buckets[$i] = $buckets[$i-1] - $this->config['bucket_size'];
        }
    
        return $buckets;
    }
}