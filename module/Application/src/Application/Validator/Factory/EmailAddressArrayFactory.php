<?php

namespace Application\Validator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Validator\EmailAddressArray;

class EmailAddressArrayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $emailValidator = new \Zend\Validator\EmailAddress();
        return new EmailAddressArray($emailValidator);
    }
}