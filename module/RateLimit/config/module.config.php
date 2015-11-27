<?php
return array(
    'rate_limit' => [
        'options' => [
            'rate_period' => 3600,
        ],
        
        'package_limits' => [
            'warn_treshold' => 3,
            'limit_treshold' => 5,
            'basic' => [
                'warn_treshold' => 5,
                'limit_treshold' => 10,
            ],
            'developer' => [
                'warn_treshold' => 20,
                'limit_treshold' => 40,
            ],
            'enterprise' => [
                'warn_treshold' => 50,
                'limit_treshold' => 80,
            ],
        ],
        
        'route_limits' => [
            
        ],
        
        'controller_limits' => [
            
        ],
        
        'rest_limits' => [
            'UserApi\\V1\Rest\\User\\Controller' => [
                'entity' => [
                    'GET' => [
                        'warn_treshold' => 5,
                        'limit_treshold' => 10,
                        'basic' => [
                            'warn_treshold' => 5,
                            'limit_treshold' => 10,
                        ],
                        'developer' => [
                            'warn_treshold' => 20,
                            'limit_treshold' => 30,
                        ],
                        'enterprise' => [
                            'warn_treshold' => 40,
                            'limit_treshold' => 50,
                        ],
                    ],
                    'POST' => null,
                    'PATCH' => [
                        
                    ],
                    'PUT' => [
                        
                    ],
                    'DELETE' => [
                        
                    ],
                ],
                'collection' => [
                    'GET' => [
                        
                    ],
                    'POST' => [
                        
                    ],
                    'PATCH' => null,
                    'PUT' => null,
                    'DELETE' => null,
                ],
            ],
        ],
    ],
    
    'service_manager' => [
        'factories' => [
            'RateLimit\Listener\RouteListener' => 'RateLimit\Listener\RouteListenerFactory',
        ],
    ],
);
