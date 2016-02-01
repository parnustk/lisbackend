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

                    .when('/room', {
                        templateUrl: 'lis/dist/templates/room.html',
                        controller: 'roomController'})

                    .when('/moduletype', {
                        templateUrl: 'lis/dist/templates/moduletype.html',
                        controller: 'moduleTypeController'})
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
