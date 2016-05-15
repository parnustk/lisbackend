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
     * @returns {studentInGroupsController_L28.studentInGroupsController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

                studentInGroupsController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'studentInGroupsModel', 'studentModel', 'studentGroupModel'];

                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} studentInGroupsModel
                 * @param {type} studentModel
                 * @param {type} gradingTypeModel
                 * @returns {studentInGroupsController_L30.studentInGroupsController}
                 */
                function studentInGroupsController($scope, $q, $routeParams, rowSorter, uiGridConstants, studentInGroupsModel, studentModel, studentGroupModel) {

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
                        student: null,
                        studentGroup: null,
                        status: null,
                        notes: null,
                        trashed: null
                    };

                    /**
                     * will hold students
                     * for grid select
                     */
                    $scope.students = [];

                    /**
                     * will hold studentGroups
                     * for grid select
                     */
                    $scope.studentGroups = [];

                    $scope.studentInGroups = {};

                    $scope.filterStudentInGroups = {};

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
                            {//select one
                                field: "student",
                                name: "student",
                                displayName: $scope.T('LIS_STUDENT'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this'},
                            {//select one
                                field: "studentGroup",
                                name: "studentGroup",
                                displayName: $scope.T('LIS_STUDENTGROUP'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this'
                            },
                            {field: 'status',
                                displayName: $scope.T('LIS_STATUS')
                            },
                            {field: 'notes',
                                displayName: $scope.T('LIS_NOTES')
                            }
                        ],
                        enableGridMenu: true,
                        enableSelectAll: true,
                        exporterCsvFilename: 'studentInGroupss.csv',
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

                    $scope.saveRow = function (rowEntity) {
                        var deferred = $q.defer();
                        studentInGroupsModel.Update(rowEntity.id, rowEntity).then(
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
                            studentInGroupsModel.Create($scope.studentInGroups).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    console.log(result);
                                    $scope.gridOptions.data.push(result.data);
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
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterStudentInGroups));
                            LoadGrid();
                        }
                    };

                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        $scope.filterStudentInGroups = {};
                        delete urlParams.where;
                        LoadGrid();
                    };

                    /**
                     * Before loading module data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadGrid() {

                        studentModel.GetList({}).then(function (result) {
                            $scope.gridOptions.data = [];
                            if (globalFunctions.resultHandler(result)) {

                                $scope.students = result.data;
                                $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.students;

                                studentGroupModel.GetList($scope.params).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {

                                        $scope.studentGroups = result.data;
                                        $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.studentGroups;

                                        studentInGroupsModel.GetList(urlParams).then(function (result) {
                                            if (globalFunctions.resultHandler(result)) {
                                                $scope.gridOptions.data = result.data;
                                            }
                                        });
                                    }
                                });

                            }
                        });
                    }

                    LoadGrid();//let's start loading data
                }

                return studentInGroupsController;
            });

}(define, document));
