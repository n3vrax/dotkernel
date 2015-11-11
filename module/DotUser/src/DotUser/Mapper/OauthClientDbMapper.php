<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class OauthClientDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'oauth_clients';
    
    protected $idField = 'client_id';
    
    public function getIdFieldName()
    {
        return $this->idField;
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
}