/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
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
     * @returns {gradingTypeController_L19.gradingTypeController_L25.gradingTypeController}
     */
    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {
                
                gradingTypeController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'gradingTypeModel'];
                
                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} gradingTypeModel
                 * @returns {undefined}
                 */
                function gradingTypeController($scope, $q, $routeParams, rowSorter, uiGridConstants, gradingTypeModel) {
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
                     * records sceleton used for reset operations
                     */
                    $scope.model = {
                        id:null,
                        name: null,
                        trashed: null
                    };

                    $scope.gradingType = {};//for form object

                    $scope.filterGradingType = {};//for form filters, object

                    /**
                     * Grid set up
                     */
                    $scope.gridOptions = {
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
                            {field: 'name',
                                displayName: $scope.T('LIS_NAME')},
                            {field: 'trashed',
                                displayName: $scope.T('LIS_TRASHED')}
                        ],
                        enableGridMenu: true,
                        enalbeSelectAll: true,
                        exporterCsvFilename: 'gradingtype.csv',
                        exporterPdfDefaultStyle: {fontSize: 9},
                        exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                        exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
                        exporterPdfHeader: {text: "Grading Type Header", style: 'headerStyle'},
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
                        gradingTypeModel.Update(rowEntity.id, rowEntity).then(
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
                     * Create
                     * 
                     * @returns {undefined}
                     */
                    $scope.Create = function (valid) {
                        if (valid) {
                            gradingTypeModel.Create($scope.gradingType).then(function (result) {
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
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterGradingType));
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
                     * Delete
                     * kustutab küll vaatest aga mitte andmebaasist :/
                     */
                    $scope.Delete = function () {//oooo :O (Y) algus tehtud 
                        //aga ma teeks vbl tiba teistmoodi, see m
                        angular.forEach($scope.gridApi.selection.getSelectedRows(),
                                function (data, index) {
                                    $scope.gridOptions.data.splice($scope.gridOptions.data.lastIndexOf(data), 1);
                                });
                    };


                    /**
                     * Before loading module data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadGrid() {
                        gradingTypeModel.GetList(urlParams).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.gridOptions.data = result.data;
                            }
                        });
                    }

                    LoadGrid();//let's start loading data
                }
                
                return gradingTypeController;
            });

}(define, document));


