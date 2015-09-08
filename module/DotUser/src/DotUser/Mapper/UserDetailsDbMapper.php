<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class UserDetailsDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'user_details';
    
    public function getTableName()
    {
        return $this->tableName;
    }
}