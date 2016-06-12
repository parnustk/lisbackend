/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

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

                .when('/userdata', {
                    templateUrl: 'lis/dist/templates/userData.html',
                    controller: 'userDataController'
                })

                .when('/', {
                    templateUrl: 'lis/dist/templates/home.html',
                    controller: 'homeController'
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
