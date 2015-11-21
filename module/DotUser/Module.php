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
    protected $services;
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $this->services = $e->getApplication()->getServiceManager();
        
        $eventManager->attach(MvcAuthEvent::EVENT_AUTHENTICATION, $this->services->get('DotUser\Authentication\AuthenticationListener'), 100);
        
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'oauthGuard'));
        
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
    
    public function oauthGuard(MvcEvent $event)
    {
        if($event->getRouteMatch()->getMatchedRouteName() === 'oauth/authorize' || 
            $event->getRouteMatch()->getMatchedRouteName() === 'oauth/code')
        {
            $auth = $this->services->get('session_authentication');
            if(!$auth->hasIdentity())
            {
                $url = $event->getRouter()->assemble([], array('name' => 'dotuser/login'));
                $host = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'on' ? 'https://' : 'http://';
                $host .= $_SERVER['HTTP_HOST'];
                $url = $host . $url . '?redirect=' . urlencode($event->getRequest()->getUriString());
                
                $response = $event->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                exit;
            }
        }
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
