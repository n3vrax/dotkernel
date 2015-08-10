<?php
return array(
    'router' => array(
        'routes' => array(
            //adding more actions to user module pointing to our custom controller
            'zfcuser' => array(
                'options' => array(
                    'defaults' => array(
                        'controller' => 'DotUser\Controller\User',
                    ),
                ),
                'child_routes' => array(
                    'confirm' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/confirm',
                            'defaults' => array(
                                'controller' => 'DotUser\Controller\User',
                                'action'     => 'confirm',
                            ),
                        ),
                    ),
                    'recovery' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/recovery',
                            'defaults' => array(
                                'controller' => 'DotUser\Controller\User',
                                'action' => 'recovery',
                            ),
                        ),
                    ),
                    'reset-password' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/reset-password',
                            'defaults' => array(
                                'controller' => 'DotUser\Controller\User',
                                'action' => 'reset-password',
                            ),
                        ),
                    ),
                    'change-password' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-password',
                            'defaults' => array(
                                'controller' => 'DotUser\Controller\User',
                                'action' => 'change-password',
                            ),
                        ),
                    ),
                    'change-email' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-email',
                            'defaults' => array(
                                'controller' => 'DotUser\Controller\User',
                                'action' => 'change-email',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'DotUser\Controller\User' => 'DotUser\Factory\UserControllerFactory',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            
        ),
        'factories' => array(
            //overwrite module options class from zfcuser module
            'zfcuser_module_options' => 'DotUser\Factory\ModuleOptionsFactory',
            'zfcuser_user_hydrator' => 'DotUser\Factory\UserHydratorFactory',
            'zfcuser_user_mapper' => 'DotUser\Factory\UserMapperFactory',
            
            'dotuser_user_details_mapper' => 'DotUser\Factory\UserDetailsMapperFactory',
            'dotuser_user_details_hydrator' => 'DotUser\Factory\UserDetailsHydratorFactory',
            
            'dotuser_details_form' => 'DotUser\Factory\Form\UserDetailsFormFactory',
            
            'DotUser\Service\UserMailHelperInterface' => 'DotUser\Factory\UserMailHelperServiceFactory',
            'DotUser\Helper\UserUtilsInterface' => 'DotUser\Factory\UserUtilsFactory',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'mail-template/confirm' => __DIR__ . '/../view/dot-user/mail-templates/confirm.phtml',
            'mail-template/reset' => __DIR__ . '/../view/dot-user/mail-templates/reset.phtml'
        ),
        //replace zfcuser default templates with ours
        'template_path_stack' => array(
            'zfcuser' => __DIR__ . '/../view',
            'dotuser' => __DIR__ . '/../view',
        ),
    ),
);
