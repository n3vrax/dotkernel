<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class UserDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'user';
    
    protected $userDetailsMapper;
    
    public function __construct(UserDetailsDbMapper $userDetailsMapper)
    {
        $this->userDetailsMapper = $userDetailsMapper;
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function getUserDetailsMapper()
    {
        return $this->userDetailsMapper;
    }
    
    public function fetchEntityBy($field, $value)
    {
        $user = parent::fetchEntityBy($field, $value);
        if($user)
        {
            $userDetails = $this->userDetailsMapper->fetchEntity($user->getId());
            if($userDetails)
                $user->setDetails($userDetails);
        }
        return $user;
    }
}