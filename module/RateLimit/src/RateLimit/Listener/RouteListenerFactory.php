<?php

namespace RateLimit\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
class RouteListenerFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        $config = $services->get('config');
        
        $rateLimitService = $services->get('RateLimit\Service\RateLimitService');
        
        $packageProvider = $services->get('RateLimit\UserPackageNameProvider');
        
        $restControllers = $this->getRestServicesFromConfig($config);
        
        return new RouteListener($rateLimitService, $packageProvider, $restControllers);
    }
    
    
    protected function getRestServicesFromConfig(array $config)
    {
        $restServices = [];
        if (!isset($config['zf-rest'])) {
            return $restServices;
        }
    
        foreach ($config['zf-rest'] as $controllerService => $restConfig) {
            if (!isset($restConfig['route_identifier_name'])) {
                continue;
            }
            $restServices[$controllerService] = $restConfig['route_identifier_name'];
        }
    
        return $restServices;
    }
}