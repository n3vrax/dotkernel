<?php

namespace DotUser\Helper;

use ZfcUser\Entity\UserInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class UserUtils implements UserUtilsInterface, ServiceLocatorAwareInterface
{
    const DEFAULT_SALT = 'asd9%_+23nfqwef?13123$!@#41_qr';
    
    protected $serviceLocator;
    
    protected $userTokenTable;
    
    public function __construct(AbstractTableGateway $userTokenTable)
    {
        $this->userTokenTable = $userTokenTable;
    }
    
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get a user token
     * @param UserInterface $user
     */
	public function createUserToken(UserInterface $user, $expire = 86400)
    {
        $config = $this->serviceLocator->get('config');
        $salt = isset($config['db']['password']) ? $config['db']['password'] : self::DEFAULT_SALT;
        
        $token = sha1($salt . $user->getId() . $user->getEmail() . microtime());
        
        try{
            $result = $this->userTokenTable->insert(array('user_id' => $user->getId(), 'token' => $token, 'expires' => strtotime("+$expire seconds")));
        }
        catch(\Exception $ex)
        {
            return false;
        }
        
        if($result === 1)
        {
            return $token;
        }
        return false;
    }
    
    public function checkUserToken(UserInterface $user, $token)
    {
        $isValid = true;
        try{
            $result = $this->userTokenTable->select(function(Select $select) use ($user){
                $select->where->equalTo('user_id', $user->getId());
                $select->order('dateCreated DESC');
            });
        }
        catch(\Exception $ex)
        {
            $isValid = false;
        }
        
        if($result)
        {
            $row = $result->current();
            if($row['token'] !== $token) $isValid = false;
            
            if($row['expires'] < time()) $isValid = false;
        }
        else{
            $isValid = false;
        }
        
        return $isValid;
    }
    
    public function deleteUserToken(UserInterface $user, $token)
    {
        $this->userTokenTable->delete(array('user_id' => $user->getId(), 'token' => $token));
    }
}