<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class UserDetailsDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'user_details';
    
    protected $idField = 'userId';
    
    public function getIdFieldName()
    {
        return $this->idField;
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
}