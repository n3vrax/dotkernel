<?php
namespace DotUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\Password\Bcrypt;
use DotUser\Mapper\UserHydrator;
use DotUser\Mapper\UserHydratorDetailsStrategy;

class UserHydratorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('zfcuser_module_options');
        $crypto  = new Bcrypt();
        $crypto->setCost($options->getPasswordCost());
        
        $hydrator = new UserHydrator($crypto);
        $hydrator->addStrategy('details', new UserHydratorDetailsStrategy($serviceLocator->get('dotuser_user_details_hydrator')));
        
        return $hydrator;
    }
}