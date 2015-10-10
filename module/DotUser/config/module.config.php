<?php
return array(
    
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
            'DotUser\\V1\\Rest\\User\\UserResource' => 'DotUser\\V1\\Rest\\User\\UserResourceFactory',
            'DotUser\\V1\\Rest\\UserDetails\\UserDetailsResource' => 'DotUser\\V1\\Rest\\UserDetails\\UserDetailsResourceFactory',
            
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
    
    'router' => array(
        'routes' => array(
            'user-api.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'DotUser\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'user-api.rest.user-details' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-details[/:user_id]',
                    'defaults' => array(
                        'controller' => 'DotUser\\V1\\Rest\\UserDetails\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'user-api.rest.user',
            1 => 'user-api.rest.user-details',
        ),
    ),
    'zf-rest' => array(
        'DotUser\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'DotUser\\V1\\Rest\\User\\UserResource',
            'route_name' => 'user-api.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'DotUser\\Entity\\UserEntity',
            'collection_class' => 'Zend\\Paginator\\Paginator',
            'service_name' => 'user',
        ),
        'DotUser\\V1\\Rest\\UserDetails\\Controller' => array(
            'listener' => 'DotUser\\V1\\Rest\\UserDetails\\UserDetailsResource',
            'route_name' => 'user-api.rest.user-details',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user_details',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
            ),
            'collection_http_methods' => array(),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'DotUser\\Entity\\UserDetailsEntity',
            'collection_class' => 'Zend\\Paginator\\Paginator',
            'service_name' => 'userDetails',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'DotUser\\V1\\Rest\\User\\Controller' => 'HalJson',
            'DotUser\\V1\\Rest\\UserDetails\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'DotUser\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'DotUser\\V1\\Rest\\UserDetails\\Controller' => array(
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'DotUser\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ),
            'DotUser\\V1\\Rest\\UserDetails\\Controller' => array(
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'DotUser\\Entity\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user-api.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ClassMethods',
            ),
            'DotUser\\Entity\\UserDetailsEntity' => array(
                'entity_identifier_name' => 'userId',
                'route_name' => 'user-api.rest.user-details',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'DotUser\\Entity\\UserDetailsHydrator',
            ),
            'Zend\\Paginator\\Paginator' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user-api.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
        ),
    ),
);
