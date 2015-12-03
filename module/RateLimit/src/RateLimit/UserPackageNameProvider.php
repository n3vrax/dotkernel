<?php

namespace RateLimit;

use Zend\Authentication\AuthenticationService;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
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
        if($identity instanceof AuthenticatedIdentity)
            $identity = $identity->getAuthenticationIdentity();
        
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
        
        //case for the apigility authenticated identity
        if(is_array($identity) && isset($identity['user_data']))
        {
            if(isset($identity['user_data'][$this->packagePropertyName]))
                return $identity['user_data'][$this->packagePropertyName];
        }
        
        return null;
    }
    
    public function getUniqueClientToken()
    {
        if(empty($this->authenticationService))
            return $_SERVER['REMOTE_ADDR'];
        
        $identity = $this->authenticationService->getIdentity();
        if($identity instanceof AuthenticatedIdentity)
        {
            $identity = $identity->getAuthenticationIdentity();
        }
        
        if(is_object($identity))
        {
            $method = "get" . ucfirst('id');
            if (method_exists($identity, $method)) {
                return $identity->$method();
            }
            
            return $_SERVER['REMOTE_ADDR'];
        }
        
        if(is_array($identity))
        {
            if(isset($identity['id']))
            {
                return $identity['id'];
            }
            
            if(isset($identity['user_data']['id']))
            {
                return $identity['user_data']['id'];
            }
            
            if(isset($identity['client_id']))
            {
                return $identity['client_id'];
            }
        }
        
        
        return $_SERVER['REMOTE_ADDR'];
        
    }

}