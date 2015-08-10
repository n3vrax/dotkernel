<?php

namespace DotUser\Entity;

use ZfcUser\Entity\UserInterface;

class User implements UserInterface
{
    protected $id;
    
    protected $displayName;
    
    protected $email;
    
    protected $password;
    
    protected $state;
    
    protected $username;
    
    
    /**
     * Entity holding user details info
     * @var UserDetailsInterface
     */
    protected $details;
    
    const ACTIVE = 'active';
    const UNCONFIRMED = 'unconfirmed';
    const DELETED = 'deleted';
    const INACTIVE = 'inactive';
   
    public function __construct()
    {
        $this->details = new UserDetails();
    }
    
    public function getDetails()
    {
        return $this->details;
    }
    
    public function setDetails(UserDetailsInterface $details = null)
    {
        $this->details = $details;
        return $this;
    }
    
    public function getDisplayName()
    {
        return $this->displayName;
    }
    
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    
    public function getState()
    {
        if(is_null($this->state))
            $this->state = self::UNCONFIRMED;
        return $this->state;
    }
    
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    
}