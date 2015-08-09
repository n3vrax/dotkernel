<?php

namespace Application\Oauth\Adapter;

class PdoAdapter extends \ZF\OAuth2\Adapter\PdoAdapter
{
    /**
     * Set the user
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function setUser($username, $password)
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