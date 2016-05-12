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
     * @returns {absenceController_L24.absenceController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                absenceController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'absenceModel',
                    'absenceReasonModel',
                    'studentModel',
                    'contactLessonModel',
                    'subjectRoundModel',
                    'teacherModel',
                    'roomModel'
                ];

                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} absenceModel
                 * @param {type} absenceReasonModel
                 * @param {type} studentModel
                 * @param {type} contactLessonModel
                 * @param {type} subjectRoundModel
                 * @param {type} teacherModel
                 * @param {type} roomModel
                 * @returns {absenceController_L28.absenceController}
                 */
                function absenceController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        absenceModel,
                        absenceReasonModel,
                        studentModel,
                        contactLessonModel,
                        subjectRoundModel,
                        teacherModel,
                        roomModel
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
                        studentAbsence: true,
                        id: null
                    };

//                    $scope.studentAbsenceFilter = {};

                    $scope.contactLessons = $scope.absenceReasons = $scope.subjectRounds = $scope.teachers = $scope.rooms = [];

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
                    
//                    $scope.absence = {};

//                    $scope.columns = [
//                        {
//                            //field: 'nr',
//                            name: 'nr',
//                            displayName: 'Jrk',
//                            visible: false,
//                            type: 'number',
//                            width: 10,
//                            enableCellEdit: false
//                        },
//                        {
//                            //field: "student['name']",
//                            name: "absenceReason['name']",
//                            displayName: 'Absence reason',
//                            enableCellEdit: false,
//                            pinnedLeft: true,
//                            width: 150
//                        }
//                    ];

                    /**
                     * Grid set up
                     */
//                    $scope.gridOptions = {
//                    };

                    /**
                     * 
                     * @param {type} valid
                     * @returns {undefined}
                     */
//                    $scope.Filter = function (valid) {
//
//                        if (valid) {
//                            resetUrlParams();
//                            var data = globalFunctions.cleanData($scope.studentAbsenceFilter);
//                            urlParamsSubjectRound.where = angular.toJson(data);
//                            getData();
//                        } else {
//                            alert($scope.T('LIS_CHECK_FORM_FIELDS'));
//                        }
//                    };

                    /**
                     * 
                     * @returns {undefined}
                     */
                    function LoadData() {
                        subjectRoundModel.GetList(urlParams).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.subjectRounds = result.data;

                                contactLessonModel.GetList(urlParams).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {
                                        $scope.contactLessons = result.data;

                                        absenceReasonModel.GetList(urlParams).then(function (result) {
                                            if (globalFunctions.resultHandler(result)) {
                                                $scope.absenceReasons = result.data;

                                                teacherModel.GetList(urlParams).then(function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
                                                        $scope.teachers = result.data;

                                                        roomModel.GetList(urlParams).then(function (result) {
                                                            if (globalFunctions.resultHandler(result)) {
                                                                $scope.rooms = result.data;

                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });

                                    }
                                });
                            }
                        });
                    }

                    LoadData();//let's start loading data
                }

                return absenceController;
            });

}(window, define, document));