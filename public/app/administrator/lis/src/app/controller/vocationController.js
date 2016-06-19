/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
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
     * @returns {vocationController_L19.vocationController_L25.vocationController}
     */
    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            vocationController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'vocationModel'];

            /**
             * 
             * @param {type} $scope
             * @param {type} $q
             * @param {type} $routeParams
             * @param {type} rowSorter
             * @param {type} uiGridConstants
             * @param {type} vocationModel
             * @returns {vocationController_L30.vocationController}
             */
            function vocationController($scope, $q, $routeParams, rowSorter, uiGridConstants, vocationModel) {

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
                    name: null,
                    vocationCode: null,
                    durationEKAP: null,
                    trashed: null
                };

                $scope.vocation = {};

                $scope.filterVocation = {};

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
                        },{
                            field: 'name',
                            displayName: $scope.T('LIS_NAME')
                        },{
                            field: 'vocationCode',
                            displayName: $scope.T('LIS_VOCATIONCODE')
                        },{
                            field: 'durationEKAP',
                            displayName: $scope.T('LIS_DURATIONEKAP')
                        },{
                            field: 'trashed',
                            displayName: $scope.T('LIS_TRASHED')
                        }
                    ],
                    enableGridMenu: true,
                    enableSelectAll: true,
                    exporterCsvFilename: 'vocations.csv',
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
                 * Update logic
                 * 
                 * @param {type} rowEntity
                 * @returns {undefined}
                 */
                $scope.saveRow = function (rowEntity) {
                    var deferred = $q.defer();
                    vocationModel.Update(rowEntity.id, rowEntity).then(
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
                        vocationModel.Create($scope.vocation).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                console.log(result);
                                LoadGrid();
                            }
                        });
                    } else {
                        globalFunctions.alertMsg('LIS_CHECK_FORM_FIELDS');
                    }
                };

                /**
                 * Set remote criteria for DB
                 * 
                 * @returns {undefined}
                 */
                $scope.Filter = function () {
                    if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                        urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterVocation));
                        LoadGrid();
                    }
                };

                /**
                 * Remove criteria
                 * 
                 * @returns {undefined}
                 */
                $scope.ClearFilters = function () {
                    $scope.filterVocation = {};
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

                    vocationModel.GetList(urlParams).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.gridOptions.data = result.data;
                        }
                    });
                }

                LoadGrid();//let's start loading data
            }

            return vocationController;
        });

}(define, document));
