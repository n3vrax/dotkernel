<?php

namespace DotMailTransporter\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Expression;
use DotMailTransporter\Entity\TransporterCollection;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\Sql\Where;

class TransporterDbMapper extends AbstractDbMapper implements TransporterMapperInterface
{
    protected $tableName = 'email_transporter';
    
    protected $tmpSelect;
    
    protected $unsetOnNull = array('connectionClass','secure','active');
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function create($data)
    {
        $result = parent::insert($data);
        
        return $this->fetch($result->getGeneratedValue());
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
        $this->tmpSelect = $select;
        
        //todo filter by params
        
        return $this->select($select);
    }
    
    public function fetchAllPaginated($params)
    {
        $resultSet = $this->fetchAll($params);
        $select = $this->tmpSelect;
        
        $countSelect = clone $select;
        $countSelect->columns(array(DbSelect::ROW_COUNT_COLUMN_NAME => new Expression('COUNT(*)')));
        
        $paginatorAdapter = new DbSelect($select, $this->dbAdapter, $resultSet, $countSelect);
        $collection = new TransporterCollection($paginatorAdapter);
        
        return $collection;
    }

    public function update($id, $data)
    {
        $where = new Where();
        $where->equalTo('id', $id);
        $result = parent::update($data, $where);
        
        return $this->fetch($id);
    }

    
    //override this method to eliminate null values if set so
    //to let mysql insert its default values for those columns
    protected function entityToArray($entity, HydratorInterface $hydrator = null)
    {
        if (is_array($entity)) {
            return $this->doUnsetOnNull($entity); // cut down on duplicate code
        } elseif (is_object($entity)) {
            if (!$hydrator) {
                $hydrator = $this->getHydrator();
            }
            return $this->doUnsetOnNull($hydrator->extract($entity));
        }
        throw new \ZfcBase\Mapper\Exception\InvalidArgumentException('Entity passed to db mapper should be an array or object.');
    }
    
    
    protected function doUnsetOnNull($data)
    {
        foreach($this->unsetOnNull as $field)
        {
            if(array_key_exists($field, $data) && null === $data[$field])
            {
                unset($data[$field]);
            }
        }
    
        return $data;
    }
    
}