/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/* global define */

/**
 * 
 * @param {type} window
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (window, define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @param {type} moment
     * @returns {contactLessonGradeController_L30.contactLessonGradeController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                contactLessonGradeController.$inject = [
                    '$filter',
                    '$location',
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'contactLessonModel',
                    'roomModel',
                    'subjectRoundModel',
                    'studentGroupModel',
                    'moduleModel',
                    'vocationModel',
                    'teacherModel',
                    'gradeService'
                ];

                function contactLessonGradeController(
                        $filter,
                        $location,
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        contactLessonModel,
                        roomModel,
                        subjectRoundModel,
                        studentGroupModel,
                        moduleModel,
                        vocationModel,
                        teacherModel,
                        gradeService) {

                    $scope.T = globalFunctions.T;

                    $scope.FormatDate = function (ds) {
                        var dObj = new Date(ds),
                                dFinal;
                        if (window.LisGlobals.L === 'et') {
                            dFinal = moment(dObj).format('DD.MM.YYYY');
                        } else {
                            dFinal = moment(dObj).format('DD/MM/YYYY');
                        }
                        return dFinal;
                    };

                    var moduleId = $routeParams.moduleId,
                            subjectRoundId = $routeParams.subjectRoundId,
                            allGrades = gradeService.list();

                    if (allGrades.length === 0) {
                        $location.path("/");
                    }

                    $scope.contactLessons = $scope.independentWorks = [];



                    for (var x in allGrades) {

                        if (allGrades[x].id === moduleId) {
                            var subjectRoundGrades = allGrades[x].subjectRound;

                            for (var y in subjectRoundGrades) {
                                if (subjectRoundGrades[y].id === subjectRoundId) {

                                    $scope.contactLessons = subjectRoundGrades[y].contactLesson;
                                    $scope.independentWorks = subjectRoundGrades[y].independentWork;

                                    break;
                                }
                            }

                            break;
                        }
                    }

//                    console.log('contact', $scope.contactLessons);
//                    console.log('independentWorks', $scope.independentWorks);

                }//class ends

                return contactLessonGradeController;
            });

}(window, define, document));