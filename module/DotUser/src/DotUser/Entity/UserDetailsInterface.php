<?php

namespace DotUser\Entity;

interface UserDetailsInterface
{
    public function getUserId();
    
    public function setUserId($id);
    
    public function getFirstName();
    
    public function setFirstName($firstName);
    
    public function getLastName();
    
    public function setLastName($lastName);
    
    public function getAddress();
    
    public function setAddress($address);
    
    public function getCity();
    
    public function setCity($city);
    
    public function getRegion();
    
    public function setRegion($region);
    
    public function getCountry();
    
    public function setCountry($country);
    
    public function getPostalCode();
    
    public function setPostalCode($postalCode);
    
    public function getPhone();
    
    public function setPhone($phone);
}