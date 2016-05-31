/** 
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

/* global define */
/**
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */

/**
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
     * @returns {independentWorkController_L21.independentWorkController_L32.independentWorkController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                superAdminController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'superAdminModel',
                    'administratorModel',
                    'teacherModel',
                    'studentModel'
                ];

                function superAdminController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        superAdminModel,
                        administratorModel,
                        teacherModel,
                        studentModel) {

                    $scope.T = globalFunctions.T;

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000,
//                        usermng: 'usermng'
                    };

                    /**
                     * records sceleton used for reset operations
                     */
                    $scope.model = {
                        administrator: null,
                        teacher: null,
                        student: null,
                        email: null,
                        password: null,
                        state: null
                    };

                    $scope.administrator = $scope.teacher = $scope.student = [];

                    $scope.module = {};//for form, object

                    $scope.filterModule = {};//for form filters, object

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
                                field: "administrator",
                                name: "administrator",
                                displayName: $scope.T('LIS_ADMINISTRATOR'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this',
                                enableCellEdit: false
                            },
                            {//select one
                                field: "teacher",
                                name: "teacher",
                                displayName: $scope.T('LIS_TEACHER'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this',
                                enableCellEdit: false
                            },
                            {//select one
                                field: "student",
                                name: "student",
                                displayName: $scope.T('LIS_STUDENT'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this',
                                enableCellEdit: false
                            },
                            {
                                field: 'email',
                                displayName: $scope.T('LIS_EMAIL')
                            },
                            {
                                field: 'password',
                                displayName: $scope.T('LIS_PASSWORD')
                            },
                            {
                                field: 'state',
                                displayName: $scope.T('LIS_STATE')
                            },
                            {
                                field: 'trashed',
                                displayName: $scope.T('LIS_TRASHED')
                            }
                        ],
                        enableGridMenu: true,
                        enableSelectAll: true,
                        exporterCsvFilename: 'Lis Users.csv',
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
                        $scope.gridApi = gridApi;
                        gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
                    };

                    /**
                     * Update logic
                     * 
                     * @param {type} rowEntity
                     * @returns {undefined}
                     */
                    $scope.saveRow = function (rowEntity) {
                        var deferred = $q.defer();
                        superAdminModel.Update(rowEntity.id, rowEntity).then(
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
                     * Set remote criteria for DB
                     * 
                     * @returns {undefined}
                     */
                    $scope.Filter = function () {
                        if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterModule));
                            LoadGrid();
                        }
                    };

                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        $scope.filterModule = {};
                        delete urlParams.where;
                        LoadGrid();
                    };


                    /**
                     * Before loading lisUser data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadData() {

                        administratorModel.GetList({}).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {

                                $scope.administrator = result.data;
                                $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.administrator;

                                teacherModel.GetList({}).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {

                                        $scope.teacher = result.data;
                                        $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.teacher;

                                        studentModel.GetList({}).then(function (result) {
                                            if (globalFunctions.resultHandler(result)) {

                                                $scope.student = result.data;
                                                $scope.gridOptions.columnDefs[3].editDropdownOptionsArray = $scope.student;

                                                superAdminModel.GetList(urlParams).then(function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
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

                    LoadData();//let's start loading data
                }

                return superAdminController;
            });

}(define, document));
