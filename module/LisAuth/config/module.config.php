<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */
return [

    'controllers' => [
        'invokables' => [
            'LisAuth\Controller\RegisterStudent' => 'LisAuth\Controller\RegisterStudentController',
        ],
    ],
    'router' => [
        'routes' => [
            'RestLisAuth' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/lisauth[/:controller][/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'LisAuth\Controller',
                        'controller' => 'LisAuth\Controller\RegisterStudent',
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
