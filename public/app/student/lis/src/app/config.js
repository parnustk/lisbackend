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
            
                .when('/absence', {
                    templateUrl: 'lis/dist/templates/absence.html',
                    controller: 'absenceController'
                })
                
                .when('/studentgrade', {
                    templateUrl: 'lis/dist/templates/studentGrade.html',
                    controller: 'studentGradeController'
                })
                
                .when('/studentgradesubjectround/:moduleId', {
                    templateUrl: 'lis/dist/templates/studentGradeSubjectRound.html',
                    controller: 'subjectRoundGradeController'
                })
                
                .when('/studentgradecontactlesson/:moduleId/:subjectRoundId', {
                    templateUrl: 'lis/dist/templates/studentGradeContactLesson.html',
                    controller: 'contactLessonGradeController'
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
