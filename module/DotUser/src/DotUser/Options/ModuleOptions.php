<?php

namespace DotUser\Options;

class ModuleOptions extends \ZfcUser\Options\ModuleOptions
{
    protected $defaultUserState = 'unconfirmed';
    
    protected $allowedLoginStates = array(null, 'active');
    
    protected $formCaptchaOptions = array(
        'class' => 'dumb',
        'options' => array(
            
        ),
    );
    
    public function getDefaultUserState()
    {
        return $this->defaultUserState;
    }
    
    public function setDefaultUserState($state)
    {
        $this->defaultUserState = $state;
        return $this;
    }
    
    public function getFormCaptchaOptions()
    {
        return $this->formCaptchaOptions;
    }
    
    public function setFormCaptchaOptions($options)
    {
        $this->formCaptchaOptions = $options;
        return $this;
    }
}