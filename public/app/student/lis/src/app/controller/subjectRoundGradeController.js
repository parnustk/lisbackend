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
     * @returns {subjectRoundController_L29.subjectRoundController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

                subjectRoundGradeController.$inject = [
                    '$location',
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'subjectRoundModel',
                    'subjectModel',
                    'studentGroupModel',
                    'teacherModel',
                    'vocationModel',
                    'moduleModel',
                    'gradeService'
                ];

                function subjectRoundGradeController(
                        $location,
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        subjectRoundModel,
                        subjectModel,
                        studentGroupModel,
                        teacherModel,
                        vocationModel,
                        moduleModel,
                        gradeService
                        ) {

                    $scope.T = globalFunctions.T;
                    $scope.moduleId = $routeParams.moduleId;
                    $scope.subjectRoundGrades = [];
                    var allGrades = gradeService.list();
                    if (allGrades.length === 0) {
                        $location.path("studentgrade");
                    }
                    for (var x in allGrades) {

                        if (allGrades[x].id === $scope.moduleId) {
                            $scope.subjectRoundGrades = allGrades[x].subjectRound;
                            break;
                        }
                    }

                    console.log($scope.subjectRoundGrades);
                }

                return subjectRoundGradeController;
            });

}(define, document));