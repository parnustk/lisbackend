<?php

namespace Administrator;

/**
 * Core will not hold accessibla controllers in the future
 */
return [

    'controllers' => [

        'invokables' => [
            'Administrator\Controller\Vocation' => 'Administrator\Controller\VocationController',
            'Administrator\Controller\Module' => 'Administrator\Controller\ModuleController',
            'Administrator\Controller\Moduletype' => 'Administrator\Controller\ModuletypeController',
            'Administrator\Controller\Gradingtype' => 'Administrator\Controller\GradingtypeController',
        ],
    ],
    'router' => [
        'routes' => [
            'RestAdministrator' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin[/:controller][/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Administrator\Controller',
                        'controller' => 'Administrator\Controller\Gradingtype',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
