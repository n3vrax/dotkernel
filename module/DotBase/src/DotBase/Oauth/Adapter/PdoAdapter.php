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
}