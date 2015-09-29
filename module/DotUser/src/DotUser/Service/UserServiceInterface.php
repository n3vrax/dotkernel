<?php
namespace DotUser\Service;

interface UserServiceInterface
{
    public function createUser($data);
    
    public function deleteUser($id);

    public function fetch($id);

    public function fetchAll($params);

    public function fetchAllPaginated($params);

    public function findUserByEmail($email);

    public function findUserByUsername($username);

    public function updateUser($id, $data);
}