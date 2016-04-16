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
                    templateUrl: 'lis/dist/templates/absenceReason.html',
                    controller: 'absenceReasonController'})

                .when('/gradechoice', {
                    templateUrl: 'lis/dist/templates/gradeChoice.html',
                    controller: 'gradeChoiceController'})

                .when('/room', {
                    templateUrl: 'lis/dist/templates/room.html',
                    controller: 'roomController'})

                .when('/moduletype', {
                    templateUrl: 'lis/dist/templates/moduleType.html',
                    controller: 'moduleTypeController'})

                .when('/absence', {
                    templateUrl: 'lis/dist/templates/absence.html',
                    controller: 'absenceController'})
                
                .when('/module', {
                    templateUrl: 'lis/dist/templates/module.html',
                    controller: 'moduleController'})
                
                .when('/student', {
                    templateUrl: 'lis/dist/templates/student.html',
                    controller: 'studentController'
                })
                
                .when('/administrator', {
                    templateUrl: 'lis/dist/templates/administrator.html',
                    controller: 'administratorController'
                })
                
                .when('/subject', {
                    templateUrl: 'lis/dist/templates/subject.html',
                    controller: 'subjectController'
                })
                
                .when('/contactlesson', {
                    templateUrl: 'lis/dist/templates/contactLesson.html',
                    controller: 'contactLessonController'
                })
                
                .when('/independentwork', {
                    templateUrl: 'lis/dist/templates/independentWork.html',
                    controller: 'independentWorkController'
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
