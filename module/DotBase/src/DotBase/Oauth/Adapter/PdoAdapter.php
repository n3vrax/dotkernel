<?php

namespace DotBase\Oauth\Adapter;

/**
 * Overwrites the PdoAdapter which comes with zf2/apigility to not use the firstname and lastname columns as these are not found
 * in the new db schema(see user_details for those). Also oauth_users table is changed to user
 * 
 * @author n3vrax
 *
 */
class PdoAdapter extends \ZF\OAuth2\Adapter\PdoAdapter implements UserRevokeInterface
{
    /**
     * Checks to see if client is still authorized by user
     * 
     * @see \DotBase\Oauth\Adapter\UserRevokeInterface::isAuthorized()
     */
    public function isAuthorized($client_id, $user_id)
    {
        $stmt = $this->db->prepare(sprintf('SELECT * FROM %s WHERE client_id=:client_id AND user_id=:user_id', $this->config['access_token_table']));
        $stmt->execute(compact('client_id','user_id'));
        
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return !empty($result);
    }

    /**
     * Revoke permissions for client and user pair
     * 
     * @see \DotBase\Oauth\Adapter\UserRevokeInterface::revokeAccess()
     */
    public function revokeToken($token, $token_type_hint = null)
    {
        if($token_type_hint === null)
        {
            //delete any token
            
        }
        
        $stmt = $this->db->prepare(sprintf('DELETE FROM %s WHERE %s=:token', $this->config[$token_type_hint . '_table'], $token_type_hint));
        return $stmt->execute(compact('token'));
    }

    /**
     * Set the user
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function setUser($username, $password, $firstname = NULL, $lastname = NULL)
    {
        // do not store in plaintext, use bcrypt
        $this->createBcryptHash($password);
    
        // if it exists, update it.
        if ($this->getUser($username)) {
            $stmt = $this->db->prepare(sprintf(
                'UPDATE %s SET password=:password where username=:username',
                $this->config['user_table']
            ));
        } else {
            $stmt = $this->db->prepare(sprintf(
                'INSERT INTO %s (username, password) '
                . 'VALUES (:username, :password)',
                $this->config['user_table']
            ));
        }
    
        return $stmt->execute(compact('username', 'password'));
    }
    
    public function getUser($username)
    {
        $stmt = $this->db->prepare($sql = sprintf('SELECT * from %s u LEFT JOIN %s as d ON u.id = d.userId WHERE username=:username ', $this->config['user_table'], $this->config['user_details_table']));
        $stmt->execute(array('username' => $username));
        
        if (!$userInfo = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }
    
        // the default behavior is to use "username" as the user_id
        return array_merge(array(
            'user_id' => $username
        ), $userInfo);
    }
}