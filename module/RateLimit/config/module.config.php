<?php
return array(
    'rate_limit' => [
        'throttlers' => [
            'per_second' => [
                'options' => [
                    'type' => 'redis',
                    'rate_period' => 3600,
                ],
            ],
            
            'daily_limits' => [
                'options' => [
                    'type' => 'redis',
                    'rate_period' => 86400,
                ],
            ],
        ],
        
        'limits' => [
            'package_limits' => [
                'warn_threshold' => ['per_second' => 5, 'daily_limits' => 980],
                'limit_threshold' => ['per_second' => 10, 'daily_limits' => 1000],
                'basic' => [
                    'warn_threshold' => ['per_second' => 5, 'daily_limits' => 980],
                    'limit_threshold' => ['per_second' => 10, 'daily_limits' => 1000],
                ],
                'developer' => [
                    'warn_threshold' => ['per_second' => 10, 'daily_limits' => 9800],
                    'limit_threshold' => ['per_second' => 20, 'daily_limits' => 10000],
                ],
                'enterprise' => [
                    'warn_threshold' => ['per_second' => 50, 'daily_limits' => 90500],
                    'limit_threshold' => ['per_second' => 70, 'daily_limits' => 100000],
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
                            'warn_threshold' => ['per_second' => 5, 'daily_limits' => 20],
                            'limit_threshold' => ['per_second' => 10, 'daily_limits' => 30],
                            'basic' => [
                                'warn_threshold' => ['per_second' => 5, 'daily_limits' => 20],
                                'limit_threshold' => ['per_second' => 10, 'daily_limits' => 30],
                            ],
                            'developer' => [
                                'warn_threshold' => ['per_second' => 10, 'daily_limits' => 20],
                                'limit_threshold' => ['per_second' => 20, 'daily_limits' => 30],
                            ],
                            'enterprise' => [
                                'warn_threshold' => ['per_second' => 50, 'daily_limits' => 20],
                                'limit_threshold' => ['per_second' => 70, 'daily_limits' => 30],
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
    ],
    
    'service_manager' => [
        'factories' => [
            'RateLimit\Listener\RouteListener' => 'RateLimit\Listener\RouteListenerFactory',
            'RateLimit\Service\RateLimitService' => 'RateLimit\Service\RateLimitServiceFactory',
        ],
    ],
);
