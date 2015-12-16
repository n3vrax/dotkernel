<?php

return [
    'rate_limit' => [
        'limits' => [
            'warn_threshold' => ['per_second' => 1, 'daily_limits' => 95],
            'limit_threshold' => ['per_second' => 2, 'daily_limits' => 100],
    
            /*'package_limits' => [
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
            ],*/
    
            /*'UserApi\\V1\Rest\\User\\Controller' => [
    
                //limits defined for all methods for this action/resource
                'warn_threshold' => ['per_second' => 2, 'daily_limits' => 10],
                'limit_threshold' => ['per_second' => 5, 'daily_limits' => 11],
    
                'entity' => [
                    //limits defined for all methods for this action/resource
                    'warn_threshold' => ['per_second' => 5, 'daily_limits' => 20],
                    'limit_threshold' => ['per_second' => 10, 'daily_limits' => 30],
    
                    'package_limits' => [
                        'basic' => [
                            'warn_threshold' => ['per_second' => 5, 'daily_limits' => 20],
                            'limit_threshold' => ['per_second' => 10, 'daily_limits' => 30],
                        ],
                    ],
    
                    'GET' => [
                        //limits defined for all packages for this controller/action/method pair
                        'warn_threshold' => ['per_second' => 5, 'daily_limits' => 20],
                        'limit_threshold' => ['per_second' => 10, 'daily_limits' => 30],
    
                        'package_limits' => [
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
                    ],
                    'POST' => null,
                    'PATCH' => [
                        'package_limits' => [
                            'enterprise' => [
                                'warn_threshold' => ['per_second' => 50, 'daily_limits' => 20],
                                'limit_threshold' => ['per_second' => 70, 'daily_limits' => 30],
                            ],
                        ],
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
            ],*/
        ],
    ],
];