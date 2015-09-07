<?php

namespace DotUser\Service;

class UserService
{
    protected $userMapper;
    
    protected $userDetailsMapper;
    
    protected $userHydrator;
    
    protected $userDetailsHydrator;
    
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
    
    public function setUserMapper($mapper)
    {
        $this->userMapper = $mapper;
        return $this;
    }
    
    public function getUserDetailsMapper()
    {
        return $this->userDetailsMapper;
    }
    
    public function setUserDetailsMapper($mapper)
    {
        $this->userDetailsMapper = $mapper;
        return $this;
    }
    
    public function getUserHydrator()
    {
        return $this->userHydrator;
    }
    
    public function setUserHydrator($hydrator)
    {
        $this->userHydrator = $hydrator;
        return $this;
    }
    
    public function getUserDetailsHydrator()
    {
        return $this->userDetailsHydrator;
    }
    
    public function setUserDetailsHydrator($hydrator)
    {
        $this->userDetailsHydrator = $hydrator;
        return $this;
    }
}