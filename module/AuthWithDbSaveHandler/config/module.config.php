<?php
namespace AuthWithDbSaveHandler;

return array(

    //controllers services...
    'controllers' => array(
        'factories' => array(
            'AuthWithDbSaveHandler\Controller\Auth' =>
            'AuthWithDbSaveHandler\Factory\Controller\AuthControllerServiceFactory'
        ),
        'invokables' => array(
            'AuthWithDbSaveHandler\Controller\Success' =>
            'AuthWithDbSaveHandler\Controller\SuccessController'
        ),
    ),

    //register auth services...
    'service_manager' => array(
        'factories' => array(
            'AuthStorage' =>
            'AuthWithDbSaveHandler\Factory\Storage\AuthStorageFactory',
            'AuthService' =>
            'AuthWithDbSaveHandler\Factory\Storage\AuthenticationServiceFactory',
        ),
    ),

    //routing configuration...
    'router' => array(
        'routes' => array(

            'auth' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/auth[/:action]',
                    'defaults' => array(
                        'controller' => 'AuthWithDbSaveHandler\Controller\Auth',
                        'action'     => 'index',
                    ),
                ),
            ),

            'success' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/success[/:action]',
                    'defaults' => array(
                        'controller' => 'AuthWithDbSaveHandler\Controller\Success',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    //setting up view_manager
    'view_manager' => array(
        'template_path_stack' => array(
            'AuthWithDbSaveHandler' => __DIR__ . '/../view',
        ),
    ),
);