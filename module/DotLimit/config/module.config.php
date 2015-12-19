<?php
return array(
    'rate_limit' => [
        //we have defined 2 default throttlers which are most usual
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
            //see ratelimit.global.php.dist
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
