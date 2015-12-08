<?php

namespace RateLimit\Service;


use Zend\Mvc\Router\RouteMatch;
use Zend\Http\Request;
use RateLimit\PackageNameProviderInterface;
class RateLimitService
{
    protected $throttlers = array();
    
    protected $limits = array();
    
    protected $userPackageProvider;
    
    protected $restControllers;
    
    public function __construct(array $throttlers, array $limits)
    {
        $this->throttlers = $throttlers;
        $this->limits = $limits;
    }
    
    public function setPackageProvider(PackageNameProviderInterface $provider)
    {
        $this->userPackageProvider = $provider;
        return $this;
    }
    
    public function getPackageProvider()
    {
        return $this->userPackageProvider;
    }
    
    public function setRestControllers(array $restControllers)
    {
        $this->restControllers = $restControllers;
        return $this;
    }
    
    public function getRestControllers()
    {
        return $this->restControllers;
    }
    
    public function consume(RouteMatch $routeMatch, Request $request)
    {
        $meterId = $this->buildMeterId($routeMatch, $request);
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
    
    public function buildMeterId(RouteMatch $routeMatch, Request $request)
    {
        $prefix = 'dotlimit';
        $packageName = $this->userPackageProvider->getPackageName();
        $packageName = empty($packageName) ? '' : $packageName;
    
        $token = $this->userPackageProvider->getUniqueClientToken();
        $token = empty($token) ? $_SERVER['REMOTE_ADDR'] : $token;
        $token = md5($token);
    
        $controller = $routeMatch->getParam('controller', '');
    
        $action = '';
        if (!array_key_exists($controller, $this->restControllers)) {
            $action = $routeMatch->getParam('action', 'index');
        }
        else{
            $identifierName = $this->restControllers[$controller];
            $id = $this->getIdentifier($identifierName, $routeMatch, $request);
            $action = $id ? 'entity' : 'collection';
        }
    
        $method = $request->getMethod();
    
        if(!empty($packageName))
            return sprintf('%s::%s#%s', implode(':', [$prefix, $controller, $action, $method]), $packageName, $token);
        else
            return sprintf('%s#%s', implode(':', [$prefix, $controller, $action, $method]), $token);
    
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
    
    protected function getIdentifier($identifierName, RouteMatch $routeMatch, $request)
    {
        $id = $routeMatch->getParam($identifierName, false);
        if ($id) {
            return $id;
        }
    
        if (!$request instanceof Request) {
            return false;
        }
    
        return $request->getQuery($identifierName, false);
    }
}