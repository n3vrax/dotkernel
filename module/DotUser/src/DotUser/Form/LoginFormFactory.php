<?php

namespace DotUser\Form;

class LoginFormFactory
{
    public function  __invoke($services)
    {
        return new LoginForm();
    }
}