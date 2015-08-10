<?php

namespace DotUser\Mapper;

use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;
use Zend\Stdlib\Hydrator\HydratorInterface;
use DotUser\Entity\UserDetails;

class UserHydratorDetailsStrategy extends DefaultStrategy
{
    protected $detailsHydrator;
    
    public function __construct(HydratorInterface $detailsHydrator)
    {
        $this->detailsHydrator = $detailsHydrator;
    }
    
    public function extract($value)
    {
        return $this->detailsHydrator->extract($value);
    }
    
    public function hydrate($value)
    {
        if(is_array($value))
        {
            if(empty($value)){ 
                $value = null;
            }
            else{
                $value = $this->detailsHydrator->hydrate($value, new UserDetails());
            }
        }
        
        return $value;
    }
}