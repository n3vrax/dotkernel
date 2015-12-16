<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/RateLimit for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DotLimit;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use DotLimit\Listener\RouteListener;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $services = $e->getApplication()->getServiceManager();
        
        $rateLimitService = $services->get('DotLimit\Service\DotLimitService');
        
        $mvcLimitEvent = new MvcLimitEvent($e, $rateLimitService);
        
        $routeListener = new RouteListener($rateLimitService, $eventManager, $mvcLimitEvent);
        
        //set to -500 priority in order to happen after authentication but before authorization
        $eventManager->attach(MvcEvent::EVENT_ROUTE, $routeListener, -500);
        
        $eventManager->attach(MvcLimitEvent::EVENT_RATELIMIT_WARN, $services->get('DotLimit\Listener\DefaultLimitWarningListener'));
        
        $eventManager->attach(MvcLimitEvent::EVENT_RATELIMIT_EXCEEDED, $services->get('DotLimit\Listener\DefaultLimitExceededListener'));
    }
}
