<?php

namespace DotUser\Mapper;

use ZfcUser\Mapper\HydratorInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserHydrator extends ClassMethods implements HydratorInterface
{   
    protected $cryptoService;

   /**
     * @param ZendCryptPassword $cryptoService
     * @param bool|array        $underscoreSeparatedKeys
     */
    public function __construct(
        PasswordInterface $cryptoService,
        $underscoreSeparatedKeys = false
        
    ) {
        parent::__construct($underscoreSeparatedKeys);
        $this->cryptoService = $cryptoService;
    }

    /**
     * Extract values from an object
     *
     * @param  UserEntity $object
     * @return array
     * @throws Exception\InvalidArgumentException
     */
    public function extract($object)
    {
        if (!$object instanceof \DotUser\Entity\User) {
            return $object;
        }
        $data = parent::extract($object);
        return $data;
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array               $data
     * @param  UserEntity $object
     * @return UserEntity
     * @throws Exception\InvalidArgumentException
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof \DotUser\Entity\User) {
            return $object;
        }
        return parent::hydrate($data, $object);
    }
    
    public function getCryptoService()
    {
        return $this->cryptoService;
    }
}
