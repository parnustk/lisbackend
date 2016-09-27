/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

/**
 * @author Sander Mets <sandermets0@gmail.com>
 */

/* global define */

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

                moduleController.$inject = [
                    '$scope',
                    '$q',
                    'uiGridConstants',
                    'moduleModel',
                    'vocationModel',
                    'moduleTypeModel',
                    'gradingTypeModel'
                ];

                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} uiGridConstants
                 * @param {type} moduleModel
                 * @param {type} vocationModel
                 * @param {type} moduleTypeModel
                 * @param {type} gradingTypeModel
                 * @returns {undefined}
                 */
                function moduleController(
                        $scope,
                        $q,
                        uiGridConstants,
                        moduleModel,
                        vocationModel,
                        moduleTypeModel,
                        gradingTypeModel) {

                    $scope.T = globalFunctions.T;

                    var urlParams = {
                        page: 1,
                        limit: 100000
                    };

                    $scope.model = {
                        name: null,
                        moduleCode: null,
                        vocation: null,
                        moduleType: null,
                        gradingType: null,
                        duration: null
                    };

                    $scope.vocations = [];

                    $scope.moduleTypes = [];

                    $scope.gradingTypes = [];

                    $scope.module = {};

                    $scope.filterModule = {};

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
                                displayName: $scope.T('LIS_VOCATION'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this'
                            },
                            {//select one
                                field: "moduleType",
                                name: "moduleType",
                                displayName: $scope.T('LIS_MODULETYPE'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this'
                            },
                            {//select many
                                field: 'gradingType',
                                name: 'gradingType',
                                displayName: $scope.T('LIS_GRADINGTYPE'),
                                cellTemplate: "<div class='ui-grid-cell-contents'><span ng-repeat='field in COL_FIELD'>{{field.name}} </span></div>",
                                editableCellTemplate: 'lis/dist/templates/partial/uiMultiNameSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name"
                            },
                            {
                                field: 'name',
                                displayName: $scope.T('LIS_NAME')
                            },
                            {
                                field: 'moduleCode',
                                displayName: $scope.T('LIS_MODULECODE')
                            },
                            {
                                field: 'duration',
                                displayName: $scope.T('LIS_DURATIONEKAP')
                            },
                            {
                                field: 'trashed',
                                displayName: $scope.T('LIS_TRASHED')
                            }
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
                                    $scope.module.moduleType = null;
                                    $scope.module.gradingType = null;
                                    $scope.module.name = null;
                                    $scope.module.moduleCode = null;
                                    $scope.module.duration = null;
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

                                moduleTypeModel.GetList($scope.params).then(function (result) {

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


