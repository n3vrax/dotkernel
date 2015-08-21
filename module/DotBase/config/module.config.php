<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'DotBase\OAuth\Adapter\PdoAdapter' => 'DotBase\OAuth\Factory\PdoAdapterFactory',
        ),
    ),
    
    'validators' => array(
        'invokables' => array(
            //validators
            'DotBase\Validator\IsBoolean' => 'DotBase\Validator\IsBoolean',
            'DotBase\Validator\IsBooleanIgnoreNull' => 'DotBase\Validator\IsBooleanIgnoreNull',
            'DotBase\Validator\StringLengthIgnoreNull' => 'DotBase\Validator\StringLengthIgnoreNull',
            'DotBase\Validator\HostnameIgnoreNull' => 'DotBase\Validator\HostnameIgnoreNull',
            'DotBase\Validator\IsIntIgnoreNull' => 'DotBase\Validator\IsIntIgnoreNull',
        ),
        'factories' => array(
            'DotBase\Validator\EmailAddressArray' => 'DotBase\Validator\Factory\EmailAddressArrayFactory',
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'DotBase' => __DIR__ . '/../view',
        ),
    ),
);
