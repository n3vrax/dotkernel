<?php

namespace RateLimit;

use Zend\Authentication\AuthenticationService;
class UserPackageNameProvider implements PackageNameProviderInterface
{
    protected $authenticationService;
    
    private $packagePropertyName = 'package';
    
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    
    public function getPackageName() 
    {
        if(empty($this->authenticationService))
            return null;

        $identity = $this->authenticationService->getIdentity();
        
        if (is_object($identity)) {
        
            $method = "get" . ucfirst($this->packagePropertyName);
            if (method_exists($identity, $method)) {
                return $identity->$method();
            }
        
            return null;
        }
        
        if (is_array($identity) && isset($identity[$this->packagePropertyName])) {
            return $identity[$this->packagePropertyName];
        }
        
        return null;
    }

}