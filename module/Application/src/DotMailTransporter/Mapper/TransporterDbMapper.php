<?php

namespace DotMailTransporter\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Expression;
use DotMailTransporter\Entity\TransporterCollection;

class TransporterDbMapper extends AbstractDbMapper implements TransporterMapperInterface
{

    protected $tableName = 'email_transporter';
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function create($data)
    {
        // TODO Auto-generated method stub
        
    }

    public function delete($id)
    {
        // TODO Auto-generated method stub
        
    }

    public function fetch($id)
    {
        $select = $this->getSelect()->where(array('id' => $id));
        
        $entity = $this->select($select)->current();
        return $entity;
        
    }

    public function fetchAll($params)
    {
        $select = $this->getSelect();

        //todo filter by params
        
        return $this->select($select);
    }
    
    public function fetchAllPaginated($params)
    {
        $resultSet = $this->fetchAll($params);
        $select = $this->getSelect();
        
        $countSelect = clone $select;
        $countSelect->columns(array(DbSelect::ROW_COUNT_COLUMN_NAME => new Expression('COUNT(*)')));
        
        $paginatorAdapter = new DbSelect($select, $this->dbAdapter, $resultSet, $countSelect);
        $collection = new TransporterCollection($paginatorAdapter);
        
        return $collection;
    }

    public function update($id, $data)
    {
        // TODO Auto-generated method stub
        
    }

    
}