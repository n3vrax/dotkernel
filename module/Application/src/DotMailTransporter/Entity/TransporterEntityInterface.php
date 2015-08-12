<?php

namespace DotMailTransporter\Entity;

interface TransporterEntityInterface
{
    public function setId($id);
    
    public function getId();
    
    public function setName($name);
    
    public function getName();
    
    public function setHostname($hostname);
    
    public function getHostname();
    
    public function setPort($port);
    
    public function getPort();
    
    public function setConnectionClass($connectionClass);
    
    public function getConnectionClass();
    
    public function setUsername($username);
    
    public function getUsername();
    
    public function setPassword($password);
    
    public function getPassword();
    
    public function setSecure($secure);
    
    public function getSecure();
    
    public function setActive($active);
    
    public function isActive();
    
}