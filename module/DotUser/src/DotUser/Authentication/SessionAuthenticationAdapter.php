<?php

namespace DotUser\Authentication;

use Zend\Authentication\Adapter\AbstractAdapter;
use DotBase\Mapper\RestMapperInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;

class SessionAuthenticationAdapter extends AbstractAdapter
{
    protected $userMapper;
    
    /**
     * @var Bcrypt
     */
    protected $bcrypt;
    
    //value used in oauth library
    protected $bcryptCost = 10;
    
    
    public function __construct(RestMapperInterface $userMapper, $config = [])
    {
        $this->userMapper = $userMapper;
        $this->bcrypt = new Bcrypt();
        if(isset($config['zf2-oauth']['storage_settings']['bcrypt_cost']))
            $this->bcryptCost = (int) $config['zf2-oauth']['storage_settings']['bcrypt_cost'];
        
        $this->bcrypt->setCost($this->bcryptCost);
    }

    public function authenticate()
    {
        $user = $this->userMapper->fetchEntityBy('email', $this->identity);
        if(!$user){
            //try to get one by username
            $user = $this->userMapper->fetchEntityBy('username', $this->identity);
        }
        
        if(!$user)
        {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->identity, array('Account with given username or email not found'));
        }
        
        if($user->getState() !== 'active')
        {
            return new Result(Result::FAILURE_UNCATEGORIZED, $this->identity, array('User account is not activated'));
        }
        
        if(!$this->checkCredential($user, $this->credential))
        {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->identity, ['Invalid user credentials']);
        }
        
        return new Result(Result::SUCCESS, $user);
        
    }

    
    public function checkCredential($user, $credential)
    {
        return $this->verifyHash($credential, $user->getPassword());
    }
    
    protected function verifyHash($check, $hash)
    {
        return $this->bcrypt->verify($check, $hash);
    }
    
}