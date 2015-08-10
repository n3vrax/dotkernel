<?php

namespace DotUser\Helper;

use ZfcUser\Entity\UserInterface;

interface UserUtilsInterface
{
    public function createUserToken(UserInterface $user, $expire);
    
    public function checkUserToken(UserInterface $user, $token);
    
    public function deleteUserToken(UserInterface $user, $token);
}