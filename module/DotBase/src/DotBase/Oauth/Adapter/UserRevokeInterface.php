<?php

namespace DotBase\Oauth\Adapter;

interface UserRevokeInterface
{
    public function revokeToken($token, $token_type_hint = null);
    
    public function isAuthorized($client_id, $user_id);
}