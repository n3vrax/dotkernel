<?php

namespace DotUser\Entity;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserHydratingStrategy implements StrategyInterface
{
    protected $hyrator;
    
    protected $entityPrototype;
    
    public function __construct(HydratorInterface $hydrator, $entityPrototype)
    {
        $this->hyrator = $hydrator;
        $this->entityPrototype = $entityPrototype;
    }
    
    public function extract($value)
    {
        if(! $value instanceof $this->entityPrototype)
        {
            throw new \Exception('extract parameter must be of type ' . get_class($this->entityPrototype));
        }
        
        return $this->detailsHydrator->extract($value);
    }
    
    public function hydrate($value)
    {
        if(is_object($value)) return $value;
        elseif(!is_array($value)) return null;
        
        if(empty($value))
        {
            $value = null;
        }
        else {
            $value = $this->detailsHydrator->hydrate($value, $this->entityPrototype);
        }
        
        return $value;
    }

    
}