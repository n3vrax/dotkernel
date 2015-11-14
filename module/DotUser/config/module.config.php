<?php
return array(
    'dotuser' => array(
        'db_adapter' => 'database',
        'user_hydrator' => 'DotUser\\Entity\\UserHydrator',
        'user_details_hydrator' => 'DotUser\\Entity\\UserDetailsHydrator',
        'user_hydrating_strategy' => array(
            0 => array(
                'field' => 'details',
                'strategy' => 'DotUser\\Entity\\UserHydratingStrategy',
            ),
        ),
        'user_entity' => 'DotUser\\Entity\\UserEntity',
        'user_details_entity' => 'DotUser\\Entity\\UserDetailsEntity',
        'user_mapper' => 'DotUser\\Mapper\\UserDbMapper',
        'user_details_mapper' => 'DotUser\\Mapper\\UserDetailsDbMapper',
        'user_service' => 'DotUser\\Service\\UserService',
        
    ),
    'hydrators' => array(
        'factories' => array(
            'DotUser\\Entity\\UserHydrator' => 'DotUser\\Factory\\Entity\\UserHydratorFactory',
            'DotUser\\Entity\\UserDetailsHydrator' => 'DotUser\\Factory\\Entity\\UserDetailsHydratorFactory',
            'DotUser\\Entity\\UserRoleHydrator' => 'DotUser\\Factory\\Entity\\UserRoleHydratorFactory',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'DotUser\\Entity\\UserEntity' => 'DotUser\\Entity\\UserEntity',
            'DotUser\\Entity\\UserDetailsEntity' => 'DotUser\\Entity\\UserDetailsEntity',
            'DotUser\\Entity\\UserRoleEntity' => 'DotUser\\Entity\\UserRoleEntity',
            'DotUser\\Entity\\OauthClientEntity' => 'DotUser\\Entity\\OauthClientEntity',
        ),
        'factories' => array(
            'DotUser\\Service\\UserService' => 'DotUser\\Factory\\Service\\UserServiceFactory',
            'DotUser\\Entity\\UserHydratingStrategy' => 'DotUser\\Factory\\Entity\\UserHydratingStrategyFactory',
            
            'DotUser\Mapper\OauthClientDbMapper' => 'DotUser\Factory\Mapper\OauthClientDbMapperFactory',
            'DotUser\Mapper\UserDbMapper' => 'DotUser\Factory\Mapper\UserDbMapperFactory',
            'DotUser\Mapper\UserDetailsDbMapper' => 'DotUser\Factory\Mapper\UserDetailsDbMapperFactory',
            'DotUser\Mapper\UserRoleDbMapper' => 'DotUser\Factory\Mapper\UserRoleDbMapperFactory',
            
            'DotUser\Listener\AuthenticationListener' => 'DotUser\Factory\Authentication\AuthenticationListenerFactory',
            'DotUser\Rbac\IdentityProvider' => 'DotUser\Rbac\IdentityProviderFactory',
            'DotUser\Rbac\DbRoleProvider' => 'DotUser\Rbac\DbRoleProviderFactory',
            'DotUser\Rbac\Authorization' => 'DotUser\Rbac\AuthorizationFactory',
            
        ),
        'shared' => array(
            'DotUser\\Entity\\UserEntity' => false,
            'DotUser\\Entity\\UserDetailsEntity' => false,
            'DotUser\\Entity\\UserRoleEntity' => false,
            'DotUser\\Entity\\OauthClientEntity' => false,
        ),
        'aliases' => array(
            'ZF\MvcAuth\Authorization\AuthorizationInterface' => 'DotUser\Rbac\Authorization',
        ),
    ),
);
