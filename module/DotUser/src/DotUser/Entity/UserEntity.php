<?php
namespace DotUser\Entity;

use Zend\Stdlib\Hydrator\Filter\FilterProviderInterface;
use Zend\Stdlib\Hydrator\Filter\GetFilter;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;

class UserEntity implements FilterProviderInterface
{

    protected $id;

    protected $username;

    protected $email;

    protected $displayName;

    protected $password;
    
    protected $roleId;

    protected $state;
    
    protected $details;
    
    protected $filter;
    
    const ACTIVE = 'active';
    const UNCONFIRMED = 'unconfirmed';
    const DELETED = 'deleted';
    const INACTIVE = 'inactive';
    
    public function __construct()
    {
        $this->filter = new FilterComposite();
        $this->filter->addFilter("get", new GetFilter());
        $this->filter->addFilter("password", new MethodMatchFilter("getPassword"), FilterComposite::CONDITION_AND);
        $this->filter->addFilter("displayName", new MethodMatchFilter("getDisplayName"), FilterComposite::CONDITION_AND);
        
    }

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
        $this->id = (int) $id;
        return $this;
    }
    
    public function getRoleId()
    {
        return $this->roleId;
    }
    
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
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
        if(is_null($this->state))
            $this->state = self::UNCONFIRMED;
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
    
    
    public function addHydratorFilter($name, $filter, $condition)
    {
        $this->filter->addFilter($name, $filter, $condition);
    }
    
    public function removeHydratorFilter($name)
    {
        if($this->filter->hasFilter($name))
            $this->filter->removeFilter($name);
    }
    
    public function getFilter()
    {
       return $this->filter;
    }
    
}
