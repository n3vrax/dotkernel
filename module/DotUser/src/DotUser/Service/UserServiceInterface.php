<?php
namespace DotUser\Service;

interface UserServiceInterface
{
    public function createUser($data);
    
    public function deleteUser($id);

    public function fetchUser($id);

    public function fetchAllUsers($params);

    public function fetchAllUsersPaginated($params);

    public function findUserByEmail($email);

    public function findUserByUsername($username);

    public function updateUser($id, $data);
}