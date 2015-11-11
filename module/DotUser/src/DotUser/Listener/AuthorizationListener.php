<?php

namespace DotUser\Listener;

use ZF\MvcAuth\MvcAuthEvent;
use ZF\MvcAuth\Authorization\AuthorizationInterface;

class AuthorizationListener
{
    protected $authorization;
    
    public function __construct(AuthorizationInterface $authorization)
    {
        $this->authorization = $authorization;
    }
    
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        
    }
}