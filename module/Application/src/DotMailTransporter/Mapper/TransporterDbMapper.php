<?php

namespace DotMailTransporter\Mapper;

use DotBase\Mapper\AbstractCrudDbMapper;

class TransporterDbMapper extends AbstractCrudDbMapper
{
    protected $tableName = 'email_transporter';
    
    public function getTableName()
    {
        return $this->tableName;
    }
}