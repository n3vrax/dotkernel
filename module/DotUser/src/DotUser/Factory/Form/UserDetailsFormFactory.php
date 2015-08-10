<?php

namespace DotUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use DotUser\Form\UserDetailsForm;
use DotUser\Form\UserDetailsFieldset;
use DotUser\Entity\UserDetails;
use DotUser\Validator\UsernameUpdateExists;
use DotUser\Form\UserDetailsInputFilter;

class UserDetailsFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $countryTable = new TableGateway('country', $dbAdapter);
        
        $userMapper = $serviceLocator->get('zfcuser_user_mapper');
        
        $userNameValidator = new UsernameUpdateExists(array(
            'mapper' => $userMapper,
            'key' => 'username',
        ));
        
        $detailsHydrator = $serviceLocator->get('dotuser_user_details_hydrator');
        
        $detailsFieldset = new UserDetailsFieldset($detailsHydrator, new UserDetails(), $countryTable);
        $inputFilter = new UserDetailsInputFilter($userNameValidator);
        
        $form = new UserDetailsForm();
        $form->setInputFilter($inputFilter);
        $form->add($detailsFieldset);
        
        return $form;
    }
}