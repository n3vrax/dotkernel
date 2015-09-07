<?php

namespace DotMailTransporter\Mapper;

use DotBase\Mapper\AbstractRestDbMapper;

class TransporterDbMapper extends AbstractRestDbMapper
{
    protected $tableName = 'email_transporter';
    
    public function getTableName()
    {
        return $this->tableName;
    }
}