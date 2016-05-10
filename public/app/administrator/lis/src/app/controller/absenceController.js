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
     * @returns {absenceController_L19.absenceController_L25.absenceController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

                absenceController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'absenceModel', 'absenceReasonModel', 'studentModel', 'contactLessonModel'];

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
                 * @returns {absenceController_L30.absenceController}
                 */
                function absenceController($scope, $q, $routeParams, rowSorter, uiGridConstants, absenceModel, absenceReasonModel, studentModel, contactLessonModel) {

                    $scope.T = globalFunctions.T;

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000 //unreal right :D think of remote pagination, see angular ui grid docs
                    };


                    /**
                     * records sceleton
                     */
                    $scope.model = {
                        id: null,
                        absenceReason: null,
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

                    $scope.absence = {};

                    $scope.filterAbsence = {};//for form filters, object

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
                                displayName: $scope.T('LIS_ABSENCEREASON'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered
                            },
                            {
                                field: "student",
                                name: "student",
                                displayName: $scope.T('LIS_STUDENT'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered
                            },
                            {
                                field: "contactLesson",
                                name: "contactLesson",
                                displayName: $scope.T('LIS_CONTACTLESSON'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                cellFilter: 'griddropdown:this',
                                sortCellFiltered: $scope.sortFiltered
                            },
                            {field: 'description',
                                displayName: $scope.T('LIS_DESCRIPTION')
                            },
                            {field: 'trashed',
                                displayName: $scope.T('LIS_TRASHED')
                            }
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
                                }
                        );
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
                                    //$scope.gridOptions.data.push(result.data);
                                    LoadGrid();
                                }
                            });
                        } else {
                            globalFunctions.alertMsg('Check form fields');
                        }
                    };

                    /**
                     * Set remote criteria for DB
                     * 
                     * @returns {undefined}
                     */
                    $scope.Filter = function () {
                        if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterAbsence));
                            LoadGrid();
                        }
                    };

                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        $scope.filterAbsence = {};
                        delete urlParams.where;
                        LoadGrid();
                    };

                    /**
                     * Before loading absence data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadGrid() {

                        absenceReasonModel.GetList({}).then(function (result) {
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

                                                absenceModel.GetList(urlParams).then(function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
//                                                $scope.absences = result.data;
//                                                $scope.gridOptions.data = $scope.absences;
                                                        $scope.gridOptions.data = result.data;
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

                return absenceController;
            });

}(define, document));