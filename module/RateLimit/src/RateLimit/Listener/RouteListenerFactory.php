<?php

namespace RateLimit\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
class ReouteListenerFactory
{
    public function __invoke(ServiceLocatorInterface $services)
    {
        return new RouteListener();
    }
}