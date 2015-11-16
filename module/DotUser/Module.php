<?php
namespace DotUser;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZF\MvcAuth\MvcAuthEvent;
use Zend\Uri\UriFactory;
use Zend\Stdlib\RequestInterface;
use Zend\Http\Header\Origin;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $services = $e->getApplication()->getServiceManager();
        
        $eventManager->attach(MvcAuthEvent::EVENT_AUTHENTICATION, $services->get('DotUser\Listener\AuthenticationListener'), 100);
        
        UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri');
        $this->fixBrokenOriginHeader($e->getRequest());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function fixBrokenOriginHeader(RequestInterface $request)
    {
        if (! method_exists($request, 'getHeaders') || ! method_exists($request, 'getServer')) {
            // Not an HTTP request
            return;
        }
    
        $origin = $request->getServer('HTTP_ORIGIN', false);
        if (! $origin) {
            // No Origin header; nothing to do
            return;
        }
    
        if ($origin !== 'file://') {
            // Origin header is likely formed correctly; nothing to do
            return;
        }
    
        $headers = $request->getHeaders();
        $headersArray = $headers->toArray();
    
        // Remove all headers
        $headers->clearHeaders();
    
        // Add the headers back one by one, but make sure the Origin headers is with the fixed value
        foreach ($headersArray as $key => $value) {
            if (strtolower($key) === 'origin') {
                $headers->addHeader(Origin::fromString('Origin: file:///'));
            } else {
                $headers->addHeaderLine($key, $value);
            }
        }
    }
}
