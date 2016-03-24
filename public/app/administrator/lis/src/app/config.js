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
                    controller: 'gradeChoiceController'})

                .when('/room', {
                    templateUrl: 'lis/dist/templates/room.html',
                    controller: 'roomController'})

                .when('/moduletype', {
                    templateUrl: 'lis/dist/templates/moduletype.html',
                    controller: 'moduletypeController'})

                .when('/absence', {
                    templateUrl: 'lis/dist/templates/absence.html',
                    controller: 'absenceController'})
                
                .when('/module', {
                    templateUrl: 'lis/dist/templates/module.html',
                    controller: 'moduleController'})

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
