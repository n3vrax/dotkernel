<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractCrudDbMapper;

class UserDbMapper extends AbstractCrudDbMapper
{
    protected $tableName = 'user';
    
    public function getTableName()
    {
        return $this->table_name;
    }
}