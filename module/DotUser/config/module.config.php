<?php
return array(
    
    'router' => array(
        'routes' => array(
            'dotuser' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        'controller' => 'DotUser\Controller\UserController',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'DotUser\Controller\UserController',
                                'action'     => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'DotUser\Controller\UserController',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
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
    
    'controllers' => array(
        'factories' => array(
            'DotUser\Controller\UserController' => 'DotUser\Controller\UserControllerFactory',
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
            
            'DotUser\Authentication\AuthenticationListener' => 'DotUser\Authentication\AuthenticationListenerFactory',
            'DotUser\Rbac\IdentityProvider' => 'DotUser\Rbac\IdentityProviderFactory',
            'ZfcRbac\Role\RoleProviderInterface' => 'DotUser\Rbac\DbRoleProviderFactory',
            'DotUser\Rbac\Authorization' => 'DotUser\Rbac\AuthorizationFactory',
            
            'Zend\Authentication\AuthenticationService' => 'DotUser\Authentication\SessionAuthenticationServiceFactory',
            'Zend\Authentication\Adapter\AbstractAdapter' => 'DotUser\Authentication\SessionAuthenticationAdapterFactory',
            
            'DotUser\Form\LoginForm' => 'DotUser\Form\LoginFormFactory',
            
        ),
        'shared' => array(
            'DotUser\\Entity\\UserEntity' => false,
            'DotUser\\Entity\\UserDetailsEntity' => false,
            'DotUser\\Entity\\UserRoleEntity' => false,
            'DotUser\\Entity\\OauthClientEntity' => false,
        ),
        'aliases' => array(
            'ZF\MvcAuth\Authorization\AuthorizationInterface' => 'DotUser\Rbac\Authorization',
            'session_authentication' => 'Zend\Authentication\AuthenticationService',
            'session_auth_adapter' => 'Zend\Authentication\Adapter\AbstractAdapter',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
