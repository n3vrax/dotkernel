<?php

namespace DotUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Service\UserMailHelperService;

class UserMailHelperServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userUtils = $serviceLocator->get('DotUser\Helper\UserUtilsInterface');
        $mailService = $serviceLocator->get('AcMailer\Service\MailService');
        
        $mailHelper = new UserMailHelperService($userUtils, $mailService);
        $mailHelper->setServiceLocator($serviceLocator);
        
        return $mailHelper;
    }
}