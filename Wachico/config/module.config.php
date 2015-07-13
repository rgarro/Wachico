<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Wachico\Controller\Admin' => 'Wachico\Controller\AdminController',
        ),
    ),
    'router' => array(
        'routes' => array(

            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'wachico' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/wachico',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Wachico\Controller',
                        'controller'    => 'Admin',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
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
    'view_manager' => array(
        'template_path_stack' => array(
            'wachico' => __DIR__ . '/../view',
        ),
    ),
);
