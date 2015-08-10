<?php

namespace DotUser\Service;

use ZfcUser\Entity\UserInterface;

interface UserMailHelperInterface
{
    public function sendConfirmEmail(UserInterface $user);
    
    public function sendResetPasswordEmail(UserInterface $user);
}