<?php
return array(
    'rate_limit' => [
        'throttlers' => [
            'per_second' => [
                'options' => [
                    'type' => 'redis',
                    'num_buckets' => 1,
                    'bucket_size' => 1,
                    'rate_period' => 1,
                    'track_meters' => false,
                ],
            ],
        
            'daily_limits' => [
                'options' => [
                    'type' => 'redis',
                    'num_buckets' => 1,
                    'bucket_size' => 86400,
                    'rate_period' => 86400,
                    'track_meters' => false,
                ],
            ],
        ],
        
        'limits' => [
            'ZF\\OAuth2\\Controller\\Auth' => [
                'warn_threshold' => ['per_second' => 0, 'daily_limits' => 0],
                'limit_threshold' => ['per_second' => 0, 'daily_limits' => 0],
            ],
            
            'DotUser\\Controller\\UserController' => [
                'warn_threshold' => ['per_second' => 0, 'daily_limits' => 0],
                'limit_threshold' => ['per_second' => 0, 'daily_limits' => 0],
            ],
            
            'Application\\Controller\\Index' => [
                'warn_threshold' => ['per_second' => 0, 'daily_limits' => 0],
                'limit_threshold' => ['per_second' => 0, 'daily_limits' => 0],
            ],
            
        ],
    ],
    
    'service_manager' => [
        'factories' => [
            'DotLimit\Service\DotLimitService' => 'DotLimit\Service\DotLimitServiceFactory',
            'DotLimit\UserPackageNameProvider' => 'DotLimit\UserPackageNameProviderFactory',
            
            'DotLimit\Listener\DefaultLimitWarningListener' => 'DotLimit\Factory\DefaultLimitWarningListenerFactory',
            'DotLimit\Listener\DefaultLimitExceededListener' => 'DotLimit\Factory\DefaultLimitExceededListenerFactory',
        ],
    ],
);
