<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class UserDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'user';
    
    public function getTableName()
    {
        return $this->table_name;
    }
}