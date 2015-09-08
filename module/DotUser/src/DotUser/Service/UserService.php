<?php

namespace DotUser\Service;

use DotBase\Mapper\RestMapperInterface;

class UserService
{
    protected $userMapper;
    
    protected $userDetailsMapper;
    
    public function __construct()
    {
        
    }
    
    public function createUser($data)
    {
        
    }
    
    public function deleteUser($id)
    {
        
    }
    
    public function fetch($id)
    {
        
    }
    
    public function fetchAll($params)
    {
        
    }
    
    public function findUserByEmail($email)
    {
        
    }
    
    public function findUserByUsername($username)
    {
        
    }
    
    public function updateUser($id, $data)
    {
        
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
    
    public function getUserDetailsMapper()
    {
        return $this->userDetailsMapper;
    }
    
    public function setUserDetailsMapper(RestMapperInterface $mapper)
    {
        $this->userDetailsMapper = $mapper;
        return $this;
    }
    
}