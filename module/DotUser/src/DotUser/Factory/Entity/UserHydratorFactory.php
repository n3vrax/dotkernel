<?php

namespace DotUser\Factory\Entity;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DotUser\Entity\UserHydrator;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class UserHydratorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $hydrator = new UserHydrator();
        
        //setup the user hydrator strategies
        if(isset($config['dotuser']['user_hydrating_strategy']) && is_array($config['dotuser']['user_hydrating_strategy']))
        {
            foreach($config['dotuser']['user_hydrating_strategy'] as $strategy)
            {
                if(!is_array($strategy) || !isset($strategy['field']) || !isset($strategy['strategy']) || 
                    empty($strategy['field']) || empty($strategy['strategy']))
                {
                    continue;
                }
                
                $hydratingStrategy = $serviceLocator->get($strategy['strategy']);
                if($hydratingStrategy instanceof StrategyInterface)
                {
                    $hydrator->addStrategy($strategy['field'], $hydratingStrategy);
                }
                
            }
        }
        
        return $hydrator;
    }
}