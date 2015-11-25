<?php

namespace DotBase\Oauth\Adapter;

interface UserRevokeInterface
{
    public function revokeAccess($client_id, $user_id);
    
    public function isAuthorized($client_id, $user_id);
}