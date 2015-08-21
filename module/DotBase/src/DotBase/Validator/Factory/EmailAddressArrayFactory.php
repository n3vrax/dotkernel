<?php

namespace DotBase\Validator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotBase\Validator\EmailAddressArray;

class EmailAddressArrayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $emailValidator = new \Zend\Validator\EmailAddress();
        return new EmailAddressArray($emailValidator);
    }
}