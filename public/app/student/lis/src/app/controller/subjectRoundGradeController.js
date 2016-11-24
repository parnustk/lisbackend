/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/* *
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
(function (window, define, document) {
    'use strict';

    /**
     * 
     * @param {type} window
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {subjectRoundGradeController_L29.subjectRoundGradeController}
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

                    $scope.goBack = function () {
                        window.history.back();
                    };

                    $scope.T = globalFunctions.T;
                    $scope.moduleId = $routeParams.moduleId;
                    $scope.subjectRoundGrades = [];
                    var allGrades = gradeService.list();
                    if (allGrades.length === 0) {
                        $location.path("/");
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

}(window, define, document));