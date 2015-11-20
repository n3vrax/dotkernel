<?php

namespace DotUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\Session\Container;

class UserController extends AbstractActionController
{
    protected $authentication;
    
    protected $loginForm;
    
    public function __construct(AuthenticationService $auth)
    {
        $this->authentication = $auth;
    }
    
    public function setLoginForm(Form $loginForm)
    {
        $this->loginForm = $loginForm;
    }
    
    public function indexAction()
    {
        if(!$this->authentication->hasIdentity())
        {
            return $this->redirect()->toRoute('dotuser/login');
        }
        
        return array();
    }
    
    public function logoutAction()
    {
        $this->authentication->clearIdentity();
        return $this->redirect()->toRoute('dotuser/login');
    }
    
    public function loginAction()
    {
        $redirect = false;
        $errors = [];
        
        if($this->authentication->hasIdentity())
        {
            return $this->redirect()->toRoute('dotuser');
        }
        
        if($this->getRequest()->isPost())
        {
            $this->loginForm->setData($this->getRequest()->getPost());
            
            if($this->loginForm->isValid())
            {
                $authAdapter = $this->authentication->getAdapter();
                
                $this->authentication->clearIdentity();
                
                $params = $this->getRequest()->getPost();
                $identity = $params->get('identity');
                $credential = $params->get('credential');
                
                
                $authAdapter->setIdentity($identity);
                $authAdapter->setCredential($credential);
                
                $result = $this->authentication->authenticate();
                if($result->isValid())
                {
                    $identity = $result->getIdentity();
                    $session = new Container($this->authentication->getStorage()->getNameSpace());
                    $session->getDefaultManager()->regenerateId();
                    
                    
                    return $this->redirect()->toRoute('dotuser');
                    
                }
                else{
                    $errors = array_merge($errors, $result->getMessages());
                }
            }
        }
        
        
        //show login form
        return array(
            'loginForm' => $this->loginForm,
            'redirect' => $redirect,
            'errors' => $errors,
        );
    }
}