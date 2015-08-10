<?php

namespace DotUser\Mapper;

interface UserDetailsInterface
{
    public function insert($details);
    
    public function update($details);
    
    public function findByUserId($userId);
}