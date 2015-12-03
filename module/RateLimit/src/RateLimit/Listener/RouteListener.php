<?php

namespace RateLimit\Listener;

use Zend\Mvc\MvcEvent;
use RateLimit\Service\RateLimitService;
use RateLimit\PackageNameProviderInterface;
use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
class RouteListener
{
    protected $rateLimitService;
    
    protected $userPackageProvider;
    
    protected $restControllers;
    
    public function __construct(RateLimitService $rateLimitService, PackageNameProviderInterface $userPackageProvider, array $restControllers = array())
    {
        $this->rateLimitService = $rateLimitService;
        $this->userPackageProvider = $userPackageProvider;
        $this->restControllers = $restControllers;
    }
    
    public function __invoke(MvcEvent $e)
    {
        $response = $e->getResponse();
        $meterId = $this->buildMeterId($e);
        $this->rateLimitService->consume($meterId);
        
        //var_dump($this->rateLimitService->getTopMeters('daily_limits'));exit;
        
        if($this->rateLimitService->isLimitWarning())
        {
            //add a warning rate limit header
            $headers = $response->getHeaders();
            $headers->addHeaderLine('X-Ratelimit-Warning', 'slow down the requests');
            $response->setHeaders($headers);
        }
        
        if($this->rateLimitService->isLimitExceeded())
        {
            $response->setStatusCode(429);
            $response->setReasonPhrase('Too Many Requests');
            
            $headers = $response->getHeaders();
            $headers->addHeaderLine('X-Ratelimit-Error', 'you have reached the request limit');
            $response->setHeaders($headers);
            
            return $response;
        }
    }
    
    public function buildMeterId(MvcEvent $e)
    {
        $request = $e->getRequest();
        
        $prefix = 'dotlimit';
        $packageName = $this->userPackageProvider->getPackageName();
        $packageName = empty($packageName) ? '' : $packageName;
        
        $token = $this->userPackageProvider->getUniqueClientToken();
        $token = empty($token) ? $_SERVER['REMOTE_ADDR'] : $token;
        $token = md5($token);
        
        $routeMatch = $e->getRouteMatch();
        
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