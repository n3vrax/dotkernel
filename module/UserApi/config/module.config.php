<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'UserApi\\V1\\Rest\\User\\UserResource' => 'UserApi\\V1\\Rest\\User\\UserResourceFactory',
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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'user-api.rest.user',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'UserApi\\V1\\Rest\\User\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'UserApi\\V1\\Rest\\User\\Controller' => array(
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
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'DotUser\\Entity\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user-api.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'dotuser_user_hydrator',
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
