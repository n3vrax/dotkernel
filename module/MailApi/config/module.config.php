<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'MailApi\\V1\\Rest\\Transporter\\TransporterResource' => 'MailApi\\V1\\Rest\\Transporter\\TransporterResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'mail-api.rpc.send' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/mail/send',
                    'defaults' => array(
                        'controller' => 'MailApi\\V1\\Rpc\\Send\\Controller',
                        'action' => 'send',
                    ),
                ),
            ),
            'mail-api.rest.transporter' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/mail/transporter[/:transporter_id]',
                    'defaults' => array(
                        'controller' => 'MailApi\\V1\\Rest\\Transporter\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'mail-api.rpc.send',
            1 => 'mail-api.rest.transporter',
        ),
    ),
    'zf-rest' => array(
        'MailApi\\V1\\Rest\\Transporter\\Controller' => array(
            'listener' => 'MailApi\\V1\\Rest\\Transporter\\TransporterResource',
            'route_name' => 'mail-api.rest.transporter',
            'route_identifier_name' => 'transporter_id',
            'collection_name' => 'transporter',
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
            'entity_class' => 'DotMailTransporter\\Entity\\TransporterEntity',
            'collection_class' => 'DotMailTransporter\\Entity\\TransporterCollection',
            'service_name' => 'transporter',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'MailApi\\V1\\Rpc\\Send\\Controller' => 'Json',
            'MailApi\\V1\\Rest\\Transporter\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'MailApi\\V1\\Rpc\\Send\\Controller' => array(
                0 => 'application/vnd.mail-api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'MailApi\\V1\\Rest\\Transporter\\Controller' => array(
                0 => 'application/vnd.mail-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'MailApi\\V1\\Rpc\\Send\\Controller' => array(
                0 => 'application/vnd.mail-api.v1+json',
                1 => 'application/json',
            ),
            'MailApi\\V1\\Rest\\Transporter\\Controller' => array(
                0 => 'application/vnd.mail-api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'DotMailTransporter\\Entity\\TransporterEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'mail-api.rest.transporter',
                'route_identifier_name' => 'transporter_id',
                'hydrator' => 'DotMailTransporter\Entity\TransporterEntityHydrator',
            ),
            'DotMailTransporter\\Entity\\TransporterCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'mail-api.rest.transporter',
                'route_identifier_name' => 'transporter_id',
                'is_collection' => true,
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'MailApi\\V1\\Rpc\\Send\\Controller' => 'MailApi\\V1\\Rpc\\Send\\SendControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'MailApi\\V1\\Rpc\\Send\\Controller' => array(
            'service_name' => 'send',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'mail-api.rpc.send',
        ),
    ),
);
