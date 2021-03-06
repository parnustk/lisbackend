<?php

namespace Core;

/**
 * Core should not be accessible overn Internet?
 */
return [

    //Core is not accessible over net
//    'controllers' => [
//
//        
//        'invokables' => [
//            'Core\Controller\Sample' => 'Core\Controller\SampleController',
//            'Core\Controller\Login' => 'Core\Controller\LoginController',
//        ],
//    ],
//    'router' => [
//        'routes' => [
//            'RestReport' => [
//                'type' => 'Segment',
//                'options' => [
//                    'route' => '/api[/:controller][/:id]',
//                    'constraints' => [
//                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id' => '[0-9]+'
//                    ],
//                    'defaults' => [
//                        '__NAMESPACE__' => 'Core\Controller',
//                        'controller' => 'Core\Controller\Sample',
//                    ],
//                ],
//            ],
//        ],
//    ],
//    'view_manager' => [
//        'strategies' => [
//            'ViewJsonStrategy',
//        ],
//    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'types' => [
                    'encryptedstring' => 'Core\Entity\CustomType\EncryptedString'
                ]
            ],
        ],
    ],
];
