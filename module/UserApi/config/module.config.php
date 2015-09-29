<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'UserApi\\V1\\Rest\\User\\UserResource' => 'UserApi\\V1\\Rest\\User\\UserResourceFactory',
            'UserApi\\V1\\Rest\\UserDetails\\UserDetailsResource' => 'UserApi\\V1\\Rest\\UserDetails\\UserDetailsResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user-api.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'UserApi\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'user-api.rest.user-details' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-details[/:user_id]',
                    'defaults' => array(
                        'controller' => 'UserApi\\V1\\Rest\\UserDetails\\Controller',
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
        'UserApi\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'UserApi\\V1\\Rest\\User\\UserResource',
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
        'UserApi\\V1\\Rest\\UserDetails\\Controller' => array(
            'listener' => 'UserApi\\V1\\Rest\\UserDetails\\UserDetailsResource',
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
            'UserApi\\V1\\Rest\\User\\Controller' => 'HalJson',
            'UserApi\\V1\\Rest\\UserDetails\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'UserApi\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'UserApi\\V1\\Rest\\UserDetails\\Controller' => array(
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'UserApi\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.user-api.v1+json',
                1 => 'application/json',
            ),
            'UserApi\\V1\\Rest\\UserDetails\\Controller' => array(
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
