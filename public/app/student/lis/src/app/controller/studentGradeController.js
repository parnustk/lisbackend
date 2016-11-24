/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
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
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
(function (window, define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {studentGradeController_L29.studentGradeController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

                studentGradeController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'studentGradeModel',
                    'studentModel',
                    'teacherModel',
                    'gradeChoiceModel',
                    'independentWorkModel',
                    'moduleModel',
                    'subjectRoundModel',
                    'contactLessonModel',
                    'gradeService'
                ];

                function studentGradeController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        studentGradeModel,
                        studentModel,
                        teacherModel,
                        gradeChoiceModel,
                        independentWorkModel,
                        moduleModel,
                        subjectRoundModel,
                        contactLessonModel,
                        gradeService
                        ) {

                    $scope.T = globalFunctions.T;

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000,
                        studentModuleGrades: true,
                        id: null
                    };

                    /**
                     * Will hold all student related grades
                     */
                    $scope.modules = [];
                    $scope.subjectRounds = [];

                    /**
                     * Before loading absence data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadData() {
                        moduleModel.GetList(urlParams).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.modules = result.data;
                                gradeService.clear();
                                gradeService.fill(result.data);
                                console.log(gradeService.list());
                            }
                        });
                    }

                    LoadData();//let's start loading data
                }

                return studentGradeController;
            });

}(window, define, document));
