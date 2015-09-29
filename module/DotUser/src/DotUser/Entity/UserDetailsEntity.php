<?php
namespace DotUser\Entity;

class UserDetailsEntity
{
    protected $userId;
    
    protected $firstName;

    protected $lastName;

    protected $address;

    protected $city;

    protected $region;

    protected $country;

    protected $postalCode;

    protected $phone;
    
    public function getUserId()
    {
        return $this->userId;
    }
    
    public function setUserId($id)
    {
        $this->userId = $id;
        return $this;
    }

    /**
     *
     * @return the $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     *
     * @param field_type $firstName            
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     *
     * @return the $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     *
     * @param field_type $lastName            
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     *
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @param field_type $address            
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     *
     * @return the $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     *
     * @param field_type $city            
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     *
     * @return the $region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     *
     * @param field_type $region            
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     *
     * @return the $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @param field_type $country            
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     *
     * @return the $postalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     *
     * @param field_type $postalCode            
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     *
     * @return the $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     *
     * @param field_type $phone            
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
}