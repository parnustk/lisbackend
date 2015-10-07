<?php

return [

    'acl' => [

        /**
         * By default the ACL is stored in this config file.
         * If you activate the database_storage ACL will be constructed from the database via Doctrine
         * and the roles and resources defined in this config wil be ignored.
         * 
         * Defaults to false.
         */
        'use_database_storage' => false,
        /**
         * The route where users are redirected if access is denied.
         * Set to empty array to disable redirection.
         */
        'redirect_route' => [

            'params' => [
            //'controller' => 'my_controllet',
            //'action' => 'my_action',
            //'id' => '1',
            ],
            'options' => [],
        ],
        'roles' => [
            'guest' => null,
            'manager' => 'guest',
            'admin' => 'manager',
        ],
        'resources' => [

            'allow' => [

                
                'Report\Controller\Search' => [
                    'getList' => 'guest',
//                    'update' => 'manager',
//                    'get' => 'manager',
//                    'create' => 'guest',
//                    'delete' => 'manager',
//                    'deleteList' => 'manager',
//                    'replaceList' => 'guest',
                ],
                'Report\Controller\Packet' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'get' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Report\Controller\Country' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Api\Controller\Search' => [
                    'getList' => 'guest',
                ],
                'Api\Controller\City' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Api\Controller\Hotel' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Api\Controller\Country' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Api\Controller\Board' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Api\Controller\Roomtype' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Api\Controller\Packettype' => [
                    'getList' => 'guest',
                    'update' => 'guest',
                    'replaceList' => 'guest',
                ],
                'Datac\Controller\Goadvee' => [
                    'all' => 'guest',
                ],
                'Datac\Controller\Iframe' => [
                    'all' => 'guest',
                ],
                'Datac\Controller\Cron' => [
                    'getList' => 'guest',
                ],
                
                'Auth\Controller\Login' => [
                    'getList' => 'guest',
                    'create' => 'guest',
                ],
                'Zend' => [
                    'uri' => 'manager'
                ],
                'Application\Controller\Index' => [
                    'all' => 'guest',
                ],
                'Datac\Controller\Test' => [
                    'all' => 'guest',
                ],
            ],
            'deny' => [

//                'Accounting\Controller\Invoicepurchase' => [
//                    'all' => 'manager',
//                ],
            ],
        ],
    ],
];
