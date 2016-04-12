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
    define(['angular', 'app/util/globalFunctions'], function (angular, globalFunctions) {

        /**
         * 
         * @param {type} $scope
         * @param {type} $q
         * @param {type} $routeParams
         * @param {type} rowSorter
         * @param {type} uiGridConstants
         * @param {type} absenceModel
         * @param {type} absencereasonModel
         * @param {type} studentModel
         * @param {type} contactLessonModel
         * @returns {absenceController_L30.absenceController}
         */
        function absenceController($scope, $q, $routeParams, rowSorter, uiGridConstants, absenceModel, absencereasonModel, studentModel, contactLessonModel) {

            /**
             * records sceleton
             */
            $scope.model = {
                id: null,
                absencereason: null,
                student: null,
                contactLesson: null,               
                description: null,
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
                        visible: false,
                        type: 'number',
                        enableCellEdit: false,
                        sort: {
                            direction: uiGridConstants.DESC,
                            priority: 1
                        }
                    },
                    {
                        field: "absenceReason",
                        name: "absenceReason",
                        displayName: 'AbsenceReason',
                        editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "name",
                        cellFilter: 'griddropdown:this',
                        sortCellFiltered: $scope.sortFiltered
                    },
                    {
                        field: "student",
                        name: "student",
                        displayName: 'Student',
                        editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "name",
                        cellFilter: 'griddropdown:this',
                        sortCellFiltered: $scope.sortFiltered
                    },
                    {
                        field: "contactLesson",
                        name: "contactLesson",
                        displayName: 'Contact Lesson',
                        editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "name",
                        cellFilter: 'griddropdown:this',
                        sortCellFiltered: $scope.sortFiltered
                    },
                    {field: 'description'},
                    {field: 'trashed'}
                ],
                enableGridMenu: true,
                enableSelectAll: true,
                exporterCsvFilename: 'absences.csv',
                exporterPdfDefaultStyle: {fontSize: 9},
                exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
                exporterPdfHeader: {text: "My Header", style: 'headerStyle'},
                exporterPdfFooter: function (currentPage, pageCount) {
                    return {text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle'};
                },
                exporterPdfCustomFormatter: function (docDefinition) {
                    docDefinition.styles.headerStyle = {fontSize: 22, bold: true};
                    docDefinition.styles.footerStyle = {fontSize: 10, bold: true};
                    return docDefinition;
                },
                exporterPdfOrientation: 'portrait',
                exporterPdfPageSize: 'LETTER',
                exporterPdfMaxGridWidth: 500,
                exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))
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
             * 
             * @param {type} rowEntity
             * @returns {undefined}
             */
            $scope.saveRow = function (rowEntity) {
                var deferred = $q.defer();
                absenceModel.Update(rowEntity.id, rowEntity).then(
                    function (result) {
                        if (result.success) {
                            deferred.resolve();
                        } else {
                            deferred.reject();
                        }
                    });
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, deferred.promise);
            };
            
            /**
             * Create new from form if succeeds push to grid
             * 
             * @param {type} valid
             * @returns {undefined}
             */
            $scope.Create = function (valid) {
                if (valid) {
                    absenceModel.Create($scope.absence).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            console.log(result);
                            $scope.gridOptions.data.push(result.data);
                            LoadGrid();
                        }
                    });
                } else {
                    alert('CHECK_FORM_FIELDS');
                }
            };
            
            /**
             * Before loading absence data, 
             * we first load relations and check success
             * 
             * @returns {undefined}
             */
            function LoadGrid() {

                absencereasonModel.GetList({}).then(function (result) {
                    $scope.gridOptions.data = [];
                    if (globalFunctions.resultHandler(result)) {

                        $scope.absenceReasons = result.data;
                        $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.absenceReasons;

                        studentModel.GetList($scope.params).then(function (result) {

                            if (globalFunctions.resultHandler(result)) {

                                $scope.students = result.data;
                                $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.students;

                                contactLessonModel.GetList($scope.params).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {

                                        $scope.contactLessons = result.data;
                                        $scope.gridOptions.columnDefs[3].editDropdownOptionsArray = $scope.contactLessons;

                                        absenceModel.GetList($scope.params).then(function (result) {
                                            if (globalFunctions.resultHandler(result)) {
                                                $scope.absences = result.data;
                                                $scope.gridOptions.data = $scope.absences;
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }

            LoadGrid();//let's start loading data
        }

        absenceController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'absenceModel', 'absencereasonModel', 'studentModel', 'contactLessonModel'];

        return absenceController;
    });

}(define, document));