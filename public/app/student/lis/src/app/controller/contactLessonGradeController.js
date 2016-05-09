/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/* global define */

/**
 * READ - http://brianhann.com/create-a-modal-row-editor-for-ui-grid-in-minutes/
 * http://brianhann.com/ui-grid-and-multi-select/#more-732
 * http://www.codelord.net/2015/09/24/$q-dot-defer-youre-doing-it-wrong/
 * http://stackoverflow.com/questions/25983035/angularjs-function-available-to-multiple-controllers
 * adding content later https://github.com/angular-ui/ui-grid/issues/2050
 * dropdown menu http://brianhann.com/ui-grid-and-dropdowns/
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {contactLessonController_L29.contactLessonController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

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

                    $scope.tToDisplay = $filter('date')($scope.date, 'dd-MM-yyyy HH:mm:ss');

                    $scope.formatDate = function (date) {
                        var dateOut = new Date(date);
                        return dateOut;
                    };

                    $scope.T = globalFunctions.T;

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

}(define, document));