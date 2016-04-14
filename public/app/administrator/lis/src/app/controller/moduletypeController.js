/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Arnold Tserepov <tserepov@gmail.com>
 * 
 */
 
 /* global define */

/**
 * READ - http://brianhann.com/create-a-modal-row-editor-for-ui-grid-in-minutes/
 * http://brianhann.com/ui-grid-and-multi-select/#more-732
 * http://www.codelord.net/2015/09/24/$q-dot-defer-youre-doing-it-wrong/
 * http://stackoverflow.com/questions/25983035/angularjs-function-available-to-multiple-controllers
 * adding content later https://github.com/angular-ui/ui-grid/issues/2050
 * dropdown menu http://brianhann.com/ui-grid-and-dropdowns/
 /**
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 * 
 */
(function (define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {moduletypeController_L19.moduletypeController_L25.moduletypeController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {

                moduletypeController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'moduletypeModel'];
                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} moduletypeModel
                 * @returns {moduletypeController_L30.moduletypeController}
                 */

                function moduletypeController($scope, $q, $routeParams, rowSorter, uiGridConstants, moduletypeModel) {
 
  /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000
                    };
                    
                    /**
                     * records sceleton
                     */
                    $scope.model = {
                        id: null,
                        name: null,
                        module: null,
                        trashed: null
                    };

                    /**
                     * will hold module
                     * for grid select
                     */
                    $scope.moduletype = [];

                    $scope.filterModuleType = {};//for form object

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
                            {field: 'name'},
                            {field: 'trashed'}
                        ],
                        enableGridMenu: true,
                        enableSelectAll: true,
                        exporterCsvFilename: 'moduletype.csv',
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
                        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
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
                     * 
                     * @param {type} rowEntity
                     * @returns {undefined}
                     */
                    $scope.saveRow = function (rowEntity) {
                        var deferred = $q.defer();
                        moduletypeModel.Update(rowEntity.id, rowEntity).then(
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
                            moduletypeModel.Create($scope.absence).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    console.log(result);
                                    //$scope.gridOptions.data.push(result.data);
                                    LoadGrid();//only needed if grid contains many column
                                //can be used for gridrefresh button
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
                    LoadGrid();
                };

                    /**
                     * Before loading moduletype data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadGrid() {

                        moduletypeModel.GetList({}).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.gridOption.data = result.data;

                            }
                        });
                    }


                    LoadGrid();//let's start loading data
                }

                return moduletypeController;
            });

}(define, document));



