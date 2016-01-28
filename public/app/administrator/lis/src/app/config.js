/* 
 * LIS development
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * 
 * @param {Function} define
 * @returns {undefined}
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
                .when('/vocation', {templateUrl: 'lis/dist/templates/vocation.html', controller: 'vocationController'})
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


