<?php
namespace DotUser\Entity;

use ZfcUser\Entity\UserInterface;

class UserEntity implements UserInterface
{

    protected $id;

    protected $username;

    protected $email;

    protected $displayName;

    protected $password;

    protected $state;
    
    protected $details;

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param field_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param field_type $username            
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     *
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param field_type $email            
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @return the $displayName
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     *
     * @param field_type $displayName            
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     *
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @param field_type $password            
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     *
     * @return the $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @param field_type $state            
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
     /**
     * @return UserDetailsEntity
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param field_type $details
     */
    public function setDetails(UserDetailsEntity $details)
    {
        $this->details = $details;
        return $this;
    }

    
    
}
