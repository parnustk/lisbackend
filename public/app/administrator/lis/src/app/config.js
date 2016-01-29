
/* global define */

/* 
 * LIS development
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * @author 
 */

(function (define) {
    'use strict';

    /**
     * 
     * @returns {config_L12.config_L18.config}
     */
    define([], function () {

        /**
         * 
         * @param {Object} $routeProvider
         * @param {Object} $locationProvider
         * @returns {undefined}
         */
        function config($routeProvider, $locationProvider) {

            $routeProvider
                    .when('/vocation', {
                        templateUrl: 'lis/dist/templates/vocation.html',
                        controller: 'vocationController'
                    })
                    .when('/teacher', {
                        templateUrl: 'lis/dist/templates/teacher.html',
                        controller: 'teacherController'
                    })
                    .when('/gradingtype', {
                        templateUrl: 'lis/dist/templates/gradingType.html',
                        controller: 'gradingTypeController'
                    })
                    .when('/absencereason', {
                        templateUrl: 'lis/dist/templates/absencereason.html',
                        controller: 'absencereasonController'})
                    .when('/gradechoice', {
                        templateUrl: 'lis/dist/templates/gradechoice.html', 
                        controller: 'gradechoiceController'})
                    .otherwise({redirectTo: '/'});

            $locationProvider.html5Mode({
                enabled: false,
                requireBase: false

            });

            $locationProvider.hashPrefix('!');
        }

        config.$inject = ['$routeProvider', '$locationProvider'];

        return config;
    });

}(define));