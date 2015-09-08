<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'DotUser\Controller\User' => 'DotUser\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dot-user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/index',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'DotUser\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'dotuser' => array(
        'db_adapter' => 'database',
    ),
    
    'hydrators' => array(
        'factories' => array(
            'dotuser_user_hydrator' => 'DotUser\Factory\Entity\UserHydratorFactory',
            'dotuser_user_details_hydrator' => 'DotUser\Factory\Entity\UserDetailsHydratorFactory',
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'dotuser_user_entity' => 'DotUser\Entity\UserEntity',
            'dotuser_user_details_entity' => 'DotUser\Entity\UserDetailsEntity',
        ),
        'factories' => array(
            'dotuser_user_mapper' => 'DotUser\Factory\Mapper\UserDbMapperFactory',
            'dotuser_user_details_mapper' => 'DotUser\Factory\Mapper\UserDetailsDbMapperFactory',
            'dotuser_user_service' => 'DotUser\Factory\Service\UserServiceFactory',
            'dotuser_user_hydrating_strategy' => 'DotUser\Factory\Entity\UserHydratingStrategyFactory',
        ),
        'shared' => array(
            'dotuser_user_entity' => false,
            'dotuser_user_details_entity' => false,
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'DotUser' => __DIR__ . '/../view',
        ),
    ),
);
