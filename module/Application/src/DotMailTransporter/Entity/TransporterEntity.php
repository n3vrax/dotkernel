<?php

namespace DotMailTransporter\Entity;

class TransporterEntity implements TransporterEntityInterface
{
    protected $id;
    
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
    }

    
    
}