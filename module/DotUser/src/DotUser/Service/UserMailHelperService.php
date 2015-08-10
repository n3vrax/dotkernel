<?php

namespace DotUser\Service;

use ZfcUser\Entity\UserInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Model\ViewModel;
use DotUser\Helper\UserUtils;
use AcMailer\Service\MailServiceInterface;

class UserMailHelperService implements UserMailHelperInterface, ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    
    protected $userUtils;
    
    protected $mailService;
    
    public function __construct(UserUtils $userUtils, MailServiceInterface $mailService)
    {
        $this->userUtils = $userUtils;
        $this->mailService = $mailService;
    }
    
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

	public function sendConfirmEmail(UserInterface $user)
    {
        $config = $this->serviceLocator->get('config');
        
        $siteName = $config['application']['site_name'];
        $siteUrl = $config['application']['site_url'];
        
        $email = $user->getEmail();
        
        $token = $this->userUtils->createUserToken($user, 864000);
        if($token)
        {
            //send confirm mail
            $mailService = $this->mailService;
            $message = $mailService->getMessage();
            $message->addTo($user->getEmail());
            $message->setSubject("$siteName - Account confirmation");
            
            
            $confirmUrl = $siteUrl. '/user/confirm?email=' . urlencode($email) . '&token=' . urlencode($token);
            
            $template = new ViewModel();
            $template->setTemplate('mail-template/confirm');
            $template->setVariables(array('confirmUrl' => $confirmUrl, 'username' => $user->getUsername()));
            
            $mailService->setTemplate($template);
            $result = $mailService->send();
            
            return $result;
        }
        else{
            error_log("Cannot create token for confirmation for user $email");
            throw new \Exception('Cannot create token for confirmation');
        }
    }

    public function sendResetPasswordEmail(UserInterface $user)
    {
        $config = $this->serviceLocator->get('config');
        
        $siteName = $config['application']['site_name'];
        
        $token = $this->userUtils->createUserToken($user);
        if($token)
        {
            $email = $user->getEmail();
            
            $link = $config['application']['site_url'] . '/user/reset-password?email=' . urlencode($email) . '&token=' . urlencode($token);
            
            $mailService = $this->mailService;
            $message = $mailService->getMessage();
            $message->addTo($user->getEmail());
            $mailService->setSubject("Reset your $siteName password");
            
            $template = new ViewModel();
            $template->setTemplate('mail-template/reset');
            $template->setVariables(array('resetLink' => $link, 'username' => $user->getUsername()));
            
            $mailService->setTemplate($template);
            $result = $mailService->send();
            
            return $result;
        }
        else{
            error_log("Cannot create token for reset password for user $email");
            throw new \Exception('Failed to create token for password reset');
        }
        
    }

    
}