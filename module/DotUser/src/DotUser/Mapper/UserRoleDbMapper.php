<?php

namespace DotUser\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class UserRoleDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'user_role';

    protected $idField = 'roleId';

    public function getIdFieldName()
    {
        return $this->idField;
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}