<?php

namespace DotUser\Authentication;

use Zend\Mvc\MvcEvent;
class OauthRouteGuard
{
    protected $dbAdapter;
    
    protected $authentication;
    
    protected $userRevokeStorage;
    
    public function __construct(\Zend\Db\Adapter\Adapter $database, \Zend\Authentication\AuthenticationService $auth, 
                                \DotBase\Oauth\Adapter\UserRevokeInterface $userRevoke)
    {
        $this->dbAdapter = $database;
        $this->authentication = $auth;
        $this->userRevokeStorage = $userRevoke;
    }
    
    public function __invoke(MvcEvent $event)
    {
        if($event->getRouteMatch()->getMatchedRouteName() === 'oauth/authorize' ||
            $event->getRouteMatch()->getMatchedRouteName() === 'oauth/code')
        {
            $auth = $this->authentication;
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
            else{
                $identity = $auth->getIdentity();
                $request = $event->getRequest(); 
                $client_id = $request->getQuery('client_id');
                //check to see if user already ganted permissions and is not revoked
                if($event->getRouteMatch()->getMatchedRouteName() === 'oauth/authorize'){
                    if($this->userRevokeStorage->isAuthorized($client_id, $identity->getUsername()))
                    {
                        $newRequest = new \ZF\ContentNegotiation\Request();
                       
                        $newRequest->setMethod(\Zend\Http\Request::METHOD_POST);
                        $newRequest->getPost()->set('authorized', 'yes');
                        
                        $event->setRequest($newRequest);
                    }
                }
            }
        }
    }
}