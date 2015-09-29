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
        return $this->userMapper->create($data);
    }
    
    public function deleteUser($id)
    {
        return $this->userMapper->delete($id);
    }
    
    public function fetch($id)
    {
        return $this->userMapper->fetch($id);
    }
    
    public function fetchAll($params)
    {
        return $this->userMapper->fetchAll($params);
    }
    
    public function fetchAllPaginated($params)
    {
        return $this->userMapper->fetchAllPaginated($params);
    }
    
    public function findUserByEmail($email)
    {
        return $this->userMapper->fetchBy('email', $email);
    }
    
    public function findUserByUsername($username)
    {
        return $this->userMapper->fetchBy('username', $username);
    }
    
    public function updateUser($id, $data)
    {
        return $this->userMapper->update($id, $data);
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