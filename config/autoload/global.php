<?php
return array(
    'db' => array(
        'adapters' => array(
            'database' => array(),
        ),
    ),
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ),
                'type' => 'regex',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'TestApi\\V1' => 'authentication',
            ),
        ),
    ),
    'zf-oauth2' => array(
        'allow_implicit' => true, // default (set to true when you need to support browser-based or mobile apps)
        'access_lifetime' => 86400, // default (set a value in seconds for access tokens lifetime)
        'enforce_state' => true,  // default
        'storage'  => 'Application\OAuth\Adapter\PdoAdapter',
    ),
);
