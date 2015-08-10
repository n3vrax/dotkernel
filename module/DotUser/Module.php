<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/DotUser for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DotUser;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Form\Element\Captcha;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;
use DotUser\Form\UserDetailsFieldset;
use DotUser\Entity\UserDetails;
use ZfcUser\Entity\UserInterface;

class Module implements AutoloaderProviderInterface
{  
    protected $serviceLocator;
    
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
        
        $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, 'injectNavbarLoginForm'), 100);
        
        $this->serviceLocator = $e->getApplication()->getServiceManager();
        
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        $events->attach('ZfcUser\Form\Register', 'init', function($e){
            $form = $e->getTarget();
            $this->addRegisterFormElements($form);
        });
        
        $events->attach('ZfcUser\Form\RegisterFilter', 'init', function($e){
            $filter = $e->getTarget();
            $this->addRegisterFilters($filter);
        });
        
        $events->attach('DotUser\Mapper\User', 'find', function($e){
            $user = $e->getParam('entity');
            if(!$user instanceof UserInterface)
                return;
            
            $userDetailsMapper = $this->serviceLocator->get('dotuser_user_details_mapper');
            //initialize user details too
            $userDetails = $userDetailsMapper->findByUserId($user->getId());
            if(!$userDetails)
                $userDetails = new UserDetails();
            $user->setDetails($userDetails);
        });
        
        $events->attach('ZfcUser\Service\User', 'register.post', function($e){
            $config = $this->serviceLocator->get('config');
            
            $user = $e->getParam('user');
            //insert user in role table
            $uid = $user->getId();
            $email = $user->getEmail();
            
            $userDetailsMapper = $this->serviceLocator->get('dotuser_user_details_mapper');
            $tgUserRoleLinker = new TableGateway('user_role_linker', $this->serviceLocator->get('Zend\Db\Adapter\Adapter'));
            if($uid)
            {
                //insert it into the roles table with user role
                $res = $tgUserRoleLinker->insert(array('user_id' => $uid, 'role_id' => 2));
                if(!$res)
                {
                    error_log("Role could not be assigned to user $email");
                    return;
                }
                
                //insert user details
                $res = $userDetailsMapper->insert($user);
                if(!$res)
                {
                    error_log("User details failed to insert for user $email");
                }
                
                $mailHelper = $this->serviceLocator->get('DotUser\Service\UserMailHelperInterface');
                try{
                    $result = $mailHelper->sendConfirmEmail($user);
                }
                catch(\Exception $ex)
                {
                    error_log("Confirmation email was not sent to $email");
                    return;
                }
                if(!$result->isValid())
                {
                    error_log("Confirmation email was not sent to $email");
                    return;
                }
            }
        });
    }
    
    public function injectNavbarLoginForm(MvcEvent $event)
    {
        $viewModel = $event->getViewModel();
        $navbarLogin = null;
        
        $auth = $this->serviceLocator->get('zfcuser_auth_service');
        if(!$auth->hasIdentity())
        {
            $renderer = $this->serviceLocator->get('ViewRenderer');
            $navbarLogin = new ViewModel();
            $navbarLogin->setTemplate('zfc-user/user/header_login');
            $navbarLoginForm = $this->serviceLocator->get('zfcuser_login_form');
            $navbarLogin->setVariable('loginForm', $navbarLoginForm);
            $navbarLogin = $renderer->render($navbarLogin);
        }
        $viewModel->setVariable('navbar_signin', $navbarLogin);
    }
    
    public function addRegisterFormElements($form)
    {
        $dbAdapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $countryTable = new TableGateway('country', $dbAdapter);
        $detailsHydrator = $this->serviceLocator->get('dotuser_user_details_hydrator');
        $detailsFieldset = new UserDetailsFieldset($detailsHydrator, new UserDetails(), $countryTable);
        
        $form->add($detailsFieldset);
        
        $options = $this->serviceLocator->get('zfcuser_module_options');
        $captchaAdapter = \Zend\Captcha\Factory::factory($options->getFormCaptchaOptions());
        $captcha = new Captcha('captcha');
        $captcha->setCaptcha($captchaAdapter);
        $captcha->setOptions(array('label' => 'Verify you are a human.'));
        
        $form->add($captcha);
    }
    
    public function addRegisterFilters($filter)
    {
        
    }
}
