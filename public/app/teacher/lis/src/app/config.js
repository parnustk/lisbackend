/* global define */

(function (define) {
    'use strict';

    /**
     * 
     * @returns {config_L12.config_L18.config}
     */
    define([], function () {

        /**
         * 
         * @param {type} $routeProvider
         * @param {type} $locationProvider
         * @param {type} $httpProvider
         * @returns {undefined}
         */
        function config($routeProvider, $locationProvider, $httpProvider) {

            $routeProvider
                    .when('/diary', {
                        templateUrl: 'lis/dist/templates/diary.html',
                        controller: 'diaryController'
                    })

                    .when('/independentwork', {
                        templateUrl: 'lis/dist/templates/independentWork.html',
                        controller: 'independentWorkController'
                    })
                    .when('/timetable', {
                        templateUrl: 'lis/dist/templates/timeTable.html',
                        controller: 'timeTableController'
                    })
                    .otherwise({redirectTo: '/'});

            $locationProvider.html5Mode({
                enabled: false,
                requireBase: false

            });

            $locationProvider.hashPrefix('!');

            $httpProvider.defaults.withCredentials = true;
        }

        config.$inject = ['$routeProvider', '$locationProvider', '$httpProvider'];

        return config;
    });

}(define));
