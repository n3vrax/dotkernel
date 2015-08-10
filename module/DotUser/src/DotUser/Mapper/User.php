<?php

namespace DotUser\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use ZfcUser\Mapper\UserInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class User extends AbstractDbMapper implements UserInterface
{
    protected $tableName  = 'user';

    public function findByEmail($email)
    {
        $select = $this->getSelect()
                       ->where(array('email' => $email));

        $entity = $this->select($select)->current();
        
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function findByUsername($username)
    {
        $select = $this->getSelect()
                       ->where(array('username' => $username));

        $entity = $this->select($select)->current();
        
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function findById($id)
    {
        $select = $this->getSelect()
                       ->where(array('id' => $id));

        $entity = $this->select($select)->current();
        
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $hydrator = $hydrator ?: $this->getHydrator();
        $userData = $hydrator->extract($entity);
        unset($userData['details']);
        
        $result = parent::insert($userData, $tableName, $hydrator);
        $uid = $result->getGeneratedValue();
        $entity->getDetails()->setUserId($uid);
        $hydrator->hydrate(array('id' => $uid), $entity);
        return $result;
    }

    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = array('id' => $entity->getId());
        }
        $hydrator = $hydrator ?: $this->getHydrator();
        $userData = $hydrator->extract($entity);
        unset($userData['details']);
        
        return parent::update($userData, $where, $tableName, $hydrator);
    }
}