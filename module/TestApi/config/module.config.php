<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'TestApi\\V1\\Rest\\Test\\TestResource' => 'TestApi\\V1\\Rest\\Test\\TestResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'test-api.rest.test' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/test[/:test_id]',
                    'defaults' => array(
                        'controller' => 'TestApi\\V1\\Rest\\Test\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'test-api.rest.test',
        ),
    ),
    'zf-rest' => array(
        'TestApi\\V1\\Rest\\Test\\Controller' => array(
            'listener' => 'TestApi\\V1\\Rest\\Test\\TestResource',
            'route_name' => 'test-api.rest.test',
            'route_identifier_name' => 'test_id',
            'collection_name' => 'test',
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
            'entity_class' => 'TestApi\\V1\\Rest\\Test\\TestEntity',
            'collection_class' => 'TestApi\\V1\\Rest\\Test\\TestCollection',
            'service_name' => 'test',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'TestApi\\V1\\Rest\\Test\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'TestApi\\V1\\Rest\\Test\\Controller' => array(
                0 => 'application/vnd.test-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'TestApi\\V1\\Rest\\Test\\Controller' => array(
                0 => 'application/vnd.test-api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'TestApi\\V1\\Rest\\Test\\TestEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'test-api.rest.test',
                'route_identifier_name' => 'test_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'TestApi\\V1\\Rest\\Test\\TestCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'test-api.rest.test',
                'route_identifier_name' => 'test_id',
                'is_collection' => true,
            ),
        ),
    ),
);
