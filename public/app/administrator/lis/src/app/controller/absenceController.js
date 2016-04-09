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
     * @returns {absenceController_L19.absenceController_L25.absenceController}
     */
    define(['angular'], function (angular) {

        /**
         * 
         * @param {Object} result
         * @returns {Boolean}
         */
        var _resultHandler = function (result) {
            var s = true;
            if (!result.success && result.message === "NO_USER") {
                alert('Login!');
                s = false;
            }
            return s;
        };

        /**
         * 
         * @param {type} $scope
         * @param {type} $q
         * @param {type} $routeParams
         * @param {type} uiGridConstants
         * @param {type} absenceModel
         * @param {type} studentModel
         * @returns {absenceController_L30.absenceController}
         */
        function absenceController($scope, $q, $routeParams, rowSorter, uiGridConstants, absenceModel, absencereasonModel, studentModel, contactLessonModel) {

            /**
             * records sceleton
             */
            $scope.model = {
                description: null,
                student: null,
                contactLesson: null,
                absenceReason: null,
                trashed: null
            };

            /**
             * will hold students
             * for grid select
             */
            $scope.students = [];

            /**
             * will hold contactLessons
             * for grid select
             */
            $scope.contactLessons = [];

            /**
             * will hold absenceReasons
             * for grid select
             */
            $scope.absenceReasons = [];

            /**
             * Grid set up
             */
            $scope.gridOptions = {
                rowHeight: 38,
                enableCellEditOnFocus: true,
                columnDefs: [
                    {
                        field: 'id',
                        visible: true,
                        type: 'number',
                        enableCellEdit: false/*,
                         sort: {
                         direction: uiGridConstants.DESC,
                         priority: 1
                         }*/
                    },
                    {field: 'description'},
                    {
                        field: "student",
                        name: "student",
                        displayName: 'Student',
                        editableCellTemplate: 'lis/dist/templates/partial/uiSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "firstName" + " " + "lastName",
//                        editDropdownOptionsArray: $scope.students,
                        editDropdownOptionsFunction: function (rowEntity, colDef) {
                            return $scope.students;
                        },
                        cellFilter: 'griddropdown:this',
                        sortCellFiltered: $scope.sortFiltered
                    },
                    {
                        field: "contactLesson",
                        name: "contactLesson",
                        displayName: 'Contact Lesson',
                        editableCellTemplate: 'lis/dist/templates/partial/uiSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "lessonDate",
//                        editDropdownOptionsArray: $scope.contactLesson,
                        editDropdownOptionsFunction: function (rowEntity, colDef) {
                            return $scope.contactLessons;
                        },
                        cellFilter: 'griddropdown:this',
                        sortCellFiltered: $scope.sortFiltered
                    },
                    {
                        field: "absenceReason",
                        name: "absenceReason",
                        displayName: 'Absence Reason',
                        editableCellTemplate: 'lis/dist/templates/partial/uiSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "name",
//                        editDropdownOptionsArray: $scope.absenceReasons,
                        editDropdownOptionsFunction: function (rowEntity, colDef) {
                            return $scope.absenceReasons;
                        },
                        cellFilter: 'griddropdown:this',
                        sortCellFiltered: $scope.sortFiltered
                    },
                    {field: 'trashed'}
                ]
//                enableGridMenu: true,
//                enableSelectAll: true,
//                exporterCsvFilename: 'absence.csv',
//                exporterPdfDefaultStyle: {fontSize: 9},
//                exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
//                exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
//                exporterPdfHeader: {text: "My Header", style: 'headerStyle'},
//                exporterPdfFooter: function (currentPage, pageCount) {
//                    return {text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle'};
//                },
//                exporterPdfCustomFormatter: function (docDefinition) {
//                    docDefinition.styles.headerStyle = {fontSize: 22, bold: true};
//                    docDefinition.styles.footerStyle = {fontSize: 10, bold: true};
//                    return docDefinition;
//                },
//                exporterPdfOrientation: 'portrait',
//                exporterPdfPageSize: 'LETTER',
//                exporterPdfMaxGridWidth: 500,
//                exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))
            };

            /**
             * Adding event handlers
             * 
             * @param {type} gridApi
             * @returns {undefined}
             */
            $scope.gridOptions.onRegisterApi = function (gridApi) {
                //set gridApi on scope
                $scope.gridApi = gridApi;
                gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
            };

            /**
             * GetList
             * @returns {undefined}
             */
//            $scope.init = function () {
////                 absenceModel.GetList($scope.params).then(
////                        function (result) {
////                            if (_resultHandler(result)) {
////                                $scope.gridOptions.data = result.data;
//                
////                contactLessonModel.GetList({}).then(function (result) {
////                    if (_resultHandler(result)) {
////                        //console.log(result.data);
////                        $scope.contactLessons = result.data;
////                
//                absencereasonModel.GetList({}).then(function (result) {
//                    if (_resultHandler(result)) {
//                        //console.log(result.data);
//                        $scope.absenceReason = result.data;
//                        
//                absenceModel.GetList($scope.params).then(
//                        function (result) {
//                            if (_resultHandler(result)) {
//                                $scope.gridOptions.data = result.data;
//                            }
//                        });
//                    }
//                });
//            };

            absencereasonModel.GetList({}).then(function (result) {
                if (_resultHandler(result)) {

                    $scope.absenceReasons = result.data;
                    $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.absenceReasons;

                    studentModel.GetList({}).then(function (result) {
                        if (_resultHandler(result)) {

                            $scope.students = result.data;
                            $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.students;
                        }
                    });

                    contactLessonModel.GetList({}).then(function (result) {
                        if (_resultHandler(result)) {

                            $scope.contactLessons = result.data;
                            $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.contactLessons;
                        }
                    });

                }
            });

            $scope.saveRow = function (rowEntity) {
                var promise = $q.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                absenceModel.Update(rowEntity.id, rowEntity).then(
                        function (result) {
                            if (result.success) {
                                promise.resolve();
                            } else {
                                promise.reject();
                            }
                        });
            };

            /**
             * Form reset the angular way
             * 
             * @returns {undefined}
             */
//            $scope.reset = function () {
//                $scope.absence = angular.copy($scope.model);
//            };
//
//            /**
//             * Create
//             * 
//             * @returns {undefined}
//             */
//            $scope.Create = function () {
//                absenceModel
//                        .Create(angular.copy($scope.absenceReasons))
//                        .then(
//                                function (result) {
//                                    if (result.success) {
//                                        $scope.gridOptions.data.push(result.data);
//                                        $scope.reset();
//                                    } else {
//                                        alert('BAD');
//                                    }
//                                }
//                        );
//            };
//            $scope.init();//Start loading data from server to grid
        }

        absenceController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'absenceModel', 'absencereasonModel', 'studentModel', 'contactLessonModel'];
        return absenceController;
    });

}(define, document));