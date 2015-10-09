<?php

namespace DotBase\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Expression;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AbstractRestDbMapper extends AbstractDbMapper implements RestMapperInterface
{
    protected $tmpSelect;
    
    protected $idField = 'id';
    
    public function getIdFieldName()
    {
        return $this->idField;
    }
    
    public function setIdFieldName($idFieldName)
    {
        $this->idField = $idFieldName;
    }
    
    public function createEntity($data)
    {
        $result = parent::insert($data);
    
        return $this->fetch($result->getGeneratedValue());
    }
    
    public function deleteEntity($id)
    {
        $result = parent::delete(array($this->idField => $id));
    
        if(!$result) return false;
    
        return true;
    }
    
    public function fetchEntity($id)
    {
        return $this->fetchBy($this->idField, $id);
    
    }
    
    public function fetchEntityBy($field, $value)
    {
        $select = $this->getSelect()->where(array($field => $value));
    
        $entity = $this->select($select)->current();
        return $entity;
    
    }
    
    public function fetchAllEntities($params)
    {
        $select = $this->getSelect();
        $this->tmpSelect = $select;
    
        //todo filter by params
    
        return $this->select($select);
    }
    
    public function fetchAllEntitiesPaginated($params)
    {
        $resultSet = $this->fetchAll($params);
        $select = $this->tmpSelect;
    
        $countSelect = clone $select;
        $countSelect->columns(array(DbSelect::ROW_COUNT_COLUMN_NAME => new Expression('COUNT(*)')));
    
        $paginatorAdapter = new DbSelect($select, $this->dbAdapter, $resultSet, $countSelect);
    
        $collection = new Paginator($paginatorAdapter);
        return $collection;
    }
    
    public function updateEntity($id, $data)
    {
        if(is_object($data))
            $data = (array) $data;
    
        if(!empty($data))
            $result = parent::update($data, array('id' => $id));
    
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
        $fields = array();
        foreach($data as $k => $v)
        {
            if(null === $v)
                $fields[] = $k;
        }
        foreach($fields as $field)
        {
            unset($data[$field]);
        }
    
        return $data;
    }
}