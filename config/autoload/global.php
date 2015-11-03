<?php
return array(
    'zf-mvc-auth' => array(
        'authentication' => array(
            'adapters' => array(),
            'map' => array(
                'MailApi\\V1' => 'oauth2',
                'UserApi\\V1' => 'oauth2',
                'DotUser\\V1' => 'oauth2',
            ),
        ),
    ),
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
);
