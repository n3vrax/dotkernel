<?php

namespace DotUser\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserDetails extends AbstractDbMapper implements \DotUser\Mapper\UserDetailsInterface
{
    protected $tableName = 'user_details';
    
    public function findByUserId($userId)
    {
        $select = $this->getSelect()->where(array('userId' => $userId));
        
        $entity = $this->select($select)->current();
        return $entity;
    }
    
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $hydrator = $hydrator ?: $this->getHydrator();
        $result = parent::insert($entity->getDetails(), $tableName, $hydrator);
        return $result;
    }
    
    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = array('userId' => $entity->getId());
        }
        
        $hydrator = $hydrator ?: $this->getHydrator();
        
        if(!$entity->getDetails()->getUserId())
        {
            $entity->getDetails()->setUserId($entity->getId());
            //probably row does not exists, insert it instead
            return $this->insert($entity, $tableName, $hydrator);
        }
        
        return parent::update($entity->getDetails(), $where, $tableName, $hydrator);
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }
}