<?php

return array(
	'navigation' => array(
    	'default' => array(
    	   array(
    	   		'label' => 'Account',
    	   		'id' => 'account',
    	   		'route' => 'user',
    	   		'pages' => array(
        	   		array(
        	   				'label' => 'Settings',
        	   				'id' => 'settings',
        	   				'route' => 'user',
        	   				'controller' => 'user',
        	   				'action' => 'index',
        	   		),
        	   		array(
        	   				'label' => 'Log Out',
        	   				'id' => 'log_out',
        	   				'route' => 'user/logout',
        	   				'controller' => 'user',
        	   				'action' => 'logout',
        	   		),
    	        ),
    	   ),
        ),
    ),
);