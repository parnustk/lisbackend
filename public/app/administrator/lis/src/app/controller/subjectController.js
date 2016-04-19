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
     * @returns {subjectController_L28.subjectController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

                subjectController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'subjectModel', 'moduleModel', 'gradingTypeModel'];

                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} subjectModel
                 * @param {type} moduleModel
                 * @param {type} gradingTypeModel
                 * @returns {subjectController_L30.subjectController}
                 */
                function subjectController($scope, $q, $routeParams, rowSorter, uiGridConstants, subjectModel, moduleModel, gradingTypeModel) {

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
                        module: null,
                        gradingType: null,
                        name: null,
                        subjectCode: null,
                        durationAllAK: null,
                        durationContactAK: null,
                        durationIndependentAK: null,
                        trashed: null
                    };

                    /**
                     * will hold modules
                     * for grid select
                     */
                    $scope.modules = [];

                    /**
                     * will hold gradingTypes
                     * for grid select
                     */
                    $scope.gradingTypes = [];

                    $scope.subject = {};

                    $scope.filterSubject = {};

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
                                field: "module",
                                name: "module",
                                displayName: 'LIS_MODULE',
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this'},
                            {//select many
                                field: "gradingType",
                                name: 'gradingType',
                                displayName: 'LIS_GRADINGTYPE',
                                cellTemplate: "<div class='ui-grid-cell-contents'><span ng-repeat='field in COL_FIELD'>{{field.name}} </span></div>",
                                editableCellTemplate: 'lis/dist/templates/partial/uiMultiNameSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name"
                            },
                            {field: 'name',
                                displayName: 'LIS_NAME'
                            },
                            {field: 'subjectCode',
                                displayName: 'LIS_SUBJECTCODE'
                            },
                            {field: 'durationAllAK',
                                displayName: 'LIS_DURATIONALLAK'
                            },
                            {field: 'durationContactAK',
                                displayName: 'LIS_DURATIONCONTACTAK'
                            },
                            {field: 'durationIndependentAK',
                                displayName: 'LIS_DURATIONINDEPENDENTAK'
                            },
                            {field: 'trashed',
                                displayName: 'LIS_TRASHED'
                            }
                        ],
                        enableGridMenu: true,
                        enableSelectAll: true,
                        exporterCsvFilename: 'subjects.csv',
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
                        subjectModel.Update(rowEntity.id, rowEntity).then(
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
                            subjectModel.Create($scope.subject).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    console.log(result);
                                    $scope.gridOptions.data.push(result.data);
                                    LoadGrid();//only needed if grid contains many column
                                    //can be used for gridrefresh button
                                    //maybe it is good to refresh after create?
                                }
                            });
                        } else {
                            alert('CHECK_FORM_FIELDS');
                        }
                    };

                    /**
                     * Set remote criteria for DB
                     * 
                     * @returns {undefined}
                     */
                    $scope.Filter = function () {
                        if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterSubject));
                            LoadGrid();
                        }
                    };

                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        $scope.filterSubject = {};
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

                        moduleModel.GetList({}).then(function (result) {
                            $scope.gridOptions.data = [];
                            if (globalFunctions.resultHandler(result)) {

                                $scope.modules = result.data;
                                $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.modules;

                                gradingTypeModel.GetList($scope.params).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {

                                        $scope.gradingTypes = result.data;
                                        $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.gradingTypes;

                                        subjectModel.GetList(urlParams).then(function (result) {
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

                return subjectController;
            });

}(define, document));