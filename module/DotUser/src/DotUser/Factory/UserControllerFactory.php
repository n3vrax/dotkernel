<?php

namespace DotUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Controller\UserController;
use DotUser\Form\ResetPasswordForm;
use DotUser\Form\ChangePasswordForm;
use DotUser\Form\ChangeEmailForm;

class UserControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $userService = $serviceLocator->get('zfcuser_user_service');
        $userUtils = $serviceLocator->get('DotUser\Helper\UserUtilsInterface');
        $mailHelper = $serviceLocator->get('DotUser\Service\UserMailHelperInterface');
        
        $resetPasswordForm = new ResetPasswordForm();
        $userDetailsForm = $serviceLocator->get('dotuser_details_form');
        $userDetailsMapper = $serviceLocator->get('dotuser_user_details_mapper');
        
        $controller = new UserController($userService);
        
        $controller->setResetPasswordForm($resetPasswordForm);
        $controller->setUserDetailsForm($userDetailsForm);
        $controller->setChangePasswordForm(new ChangePasswordForm());
        $controller->setChangeEmailForm(new ChangeEmailForm());
        $controller->setUserDetailsMapper($userDetailsMapper);
        
        $controller->setUserUtils($userUtils);
        $controller->setMailHelper($mailHelper);
        
        return $controller;
    }
}