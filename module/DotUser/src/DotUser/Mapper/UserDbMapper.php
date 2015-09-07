<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class UserDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'user';
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }
}