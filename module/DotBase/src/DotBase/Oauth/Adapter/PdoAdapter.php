<?php

namespace DotBase\Oauth\Adapter;

/**
 * Overwrites the PdoAdapter which comes with zf2/apigility to not use the firstname and lastname columns as these are not found
 * in the new db schema(see user_details for those). Also oauth_users table is changed to user
 * 
 * @author n3vrax
 *
 */
class PdoAdapter extends \ZF\OAuth2\Adapter\PdoAdapter
{
    const PROFILE_CLAIM_VALUES  = 'username state display_name details firstName lastName';
    const ADDRESS_CLAIM_VALUES  = 'address city region country postalCode';
    const PHONE_CLAIM_VALUES    = 'phone';
    
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