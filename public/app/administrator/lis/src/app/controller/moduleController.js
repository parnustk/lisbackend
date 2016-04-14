/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
     * @returns {moduleController_L21.moduleController_L32.moduleController}
     */
    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            moduleController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'moduleModel', 'vocationModel', 'moduletypeModel', 'gradingTypeModel'];
            /**
             * 
             * @param {type} $scope
             * @param {type} $q
             * @param {type} $routeParams
             * @param {type} rowSorter
             * @param {type} uiGridConstants
             * @param {type} moduleModel
             * @param {type} vocationModel
             * @param {type} moduletypeModel
             * @param {type} gradingTypeModel
             * @returns {undefined}
             */
            function moduleController($scope, $q, $routeParams, rowSorter, uiGridConstants, moduleModel, vocationModel, moduletypeModel, gradingTypeModel) {

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
                 * records sceleton used for reset operations
                 */
                $scope.model = {
                    name: null,
                    moduleCode: null,
                    vocation: null,
                    moduleType: null,
                    gradingType: null,
                    duration: null
                };

                $scope.vocations = $scope.moduleTypes = $scope.gradingTypes = [];//for ui-select in form

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
                            field: "vocation",
                            name: "vocation",
                            displayName: 'Vocation',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "moduleType",
                            name: "moduleType",
                            displayName: 'Module Type',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select many
                            field: 'gradingType',
                            name: 'gradingType',
                            displayName: 'gradingTypes',
                            cellTemplate: "<div class='ui-grid-cell-contents'><span ng-repeat='field in COL_FIELD'>{{field.name}} </span></div>",
                            editableCellTemplate: 'lis/dist/templates/partial/uiMultiNameSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name"
                        },
                        {field: 'name'},
                        {field: 'moduleCode'},
                        {field: 'duration'},
                        {field: 'trashed'}
                    ],
                    enableGridMenu: true,
                    enableSelectAll: true,
                    exporterCsvFilename: 'modules.csv',
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
                    moduleModel.Update(rowEntity.id, rowEntity).then(
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
                        moduleModel.Create($scope.module).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                console.log(result);
                                //$scope.gridOptions.data.push(result.data);
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
                 * Before loading module data, 
                 * we first load relations and check success
                 * 
                 * @returns {undefined}
                 */
                function LoadGrid() {

                    vocationModel.GetList({}).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {

                            $scope.vocations = result.data;
                            $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.vocations;

                            moduletypeModel.GetList($scope.params).then(function (result) {

                                if (globalFunctions.resultHandler(result)) {

                                    $scope.moduleTypes = result.data;
                                    $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.moduleTypes;

                                    gradingTypeModel.GetList($scope.params).then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {

                                            $scope.gradingTypes = result.data;
                                            $scope.gridOptions.columnDefs[3].editDropdownOptionsArray = $scope.gradingTypes;

                                            moduleModel.GetList(urlParams).then(function (result) {
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

                LoadGrid();//let's start loading data
            }

            return moduleController;
        });

}(define, document));


