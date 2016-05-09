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
                    'teacherModel'
                ];

                function contactLessonGradeController(
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
                        teacherModel) {

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
                    $scope.contactLessons = [];

//                    /**
//                     * Before loading absence data, 
//                     * we first load relations and check success
//                     * 
//                     * @returns {undefined}
//                     */
//                    function LoadData() {
//                        contactLessonModel.GetList(urlParams).then(function (result) {
//                            if (globalFunctions.resultHandler(result)) {
//                                $scope.contactLessons = result.data;
//                            }
//                        });
//                    }
//
//                    LoadData();//let's start loading data
                }

                return contactLessonGradeController;
            });

}(define, document));