<?php
return array(
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
        //customizable service names for important user classes
        //overwrite these for custom logic of your own
        'db_adapter' => 'database',
        
        'user_hydrator' => 'DotUser\Entity\UserHydrator',
        'user_details_hydrator' => 'DotUser\Entity\UserDetailsHydrator',
        'user_hydrating_strategy' => array(
            array(
                'field' => 'details',
                'strategy' => 'DotUser\Entity\UserHydratingStrategyFactory',
            ),
        ),
        'user_entity' => 'DotUser\Entity\UserEntity',
        'user_details_entity' => 'DotUser\Entity\UserDetailsEntity',
        'user_mapper' => 'DotUser\Mapper\UserDbMapper',
        'user_details_mapper' => 'DotUser\Mapper\UserDetailsDbMapper',
        
        'user_service' => 'DotUser\Service\UserServiceFactory',
    ),
    
    'hydrators' => array(
        'factories' => array(
            'DotUser\Entity\UserHydrator' => 'DotUser\Factory\Entity\UserHydratorFactory',
            'DotUser\Entity\UserDetailsHydrator' => 'DotUser\Factory\Entity\UserDetailsHydratorFactory',
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
            'DotUser\Entity\UserEntity' => 'DotUser\Entity\UserEntity',
            'DotUser\Entity\UserDetailsEntity' => 'DotUser\Entity\UserDetailsEntity',
        ),
        'factories' => array(
            'DotUser\Mapper\UserDbMapper' => 'DotUser\Factory\Mapper\UserDbMapperFactory',
            'DotUser\Mapper\UserDetailsDbMapper' => 'DotUser\Factory\Mapper\UserDetailsDbMapperFactory',
            'DotUser\Service\UserServiceFactory' => 'DotUser\Factory\Service\UserServiceFactory',
            'DotUser\Entity\UserHydratingStrategyFactory' => 'DotUser\Factory\Entity\UserHydratingStrategyFactory',
        ),
        'shared' => array(
            'DotUser\Entity\UserEntity' => false,
            'DotUser\Entity\UserDetailsEntity' => false,
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'DotUser' => __DIR__ . '/../view',
        ),
    ),
);
