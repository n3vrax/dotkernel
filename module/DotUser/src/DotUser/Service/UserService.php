<?php

namespace DotUser\Service;

use DotBase\Mapper\RestMapperInterface;

class UserService implements UserServiceInterface
{
    protected $userMapper;
    
    public function __construct()
    {
        
    }
    
    public function createUser($data)
    {
        return $this->userMapper->createEntity($data);
    }
    
    public function deleteUser($id)
    {
        return $this->userMapper->deleteEntity($id);
    }
    
    public function fetch($id)
    {
        return $this->userMapper->fetchEntity($id);
    }
    
    public function fetchAll($params)
    {
        return $this->userMapper->fetchAllEntities($params);
    }
    
    public function fetchAllPaginated($params)
    {
        return $this->userMapper->fetchAllEntitiesPaginated($params);
    }
    
    public function findUserByEmail($email)
    {
        return $this->userMapper->fetchEntityBy('email', $email);
    }
    
    public function findUserByUsername($username)
    {
        return $this->userMapper->fetchEntityBy('username', $username);
    }
    
    public function updateUser($id, $data)
    {
        return $this->userMapper->updateEntity($id, $data);
    }
    
    
    public function getUserMapper()
    {
        return $this->userMapper;
    }
    
    public function setUserMapper(RestMapperInterface $mapper)
    {
        $this->userMapper = $mapper;
        return $this;
    }
    
}