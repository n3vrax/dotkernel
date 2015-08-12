<?php

namespace DotMailTransporter\Entity;

class TransporterEntity implements TransporterEntityInterface
{
    protected $id;
    
    protected $name;
    
    protected $hostname;
    
    protected $port;
    
    protected $connectionClass;
    
    protected $username;
    
    protected $password;
    
    protected $secure;
    
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return the $hostname
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param field_type $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * @return the $port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param field_type $port
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return the $connectionClass
     */
    public function getConnectionClass()
    {
        return $this->connectionClass;
    }

    /**
     * @param field_type $connectionClass
     */
    public function setConnectionClass($connectionClass)
    {
        $this->connectionClass = $connectionClass;
        return $this;
    }

    /**
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param field_type $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param field_type $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return the $secure
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * @param field_type $secure
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * @return the $active
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param field_type $active
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    
    
}