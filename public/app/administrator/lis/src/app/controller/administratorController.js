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
     * @returns {administratorController_L28.administratorController}
     */
    define(['angular'], function (angular) {

        /**
         * 
         * @param {Object} result
         * @returns {Boolean}
         */
        var _resultHandler = function (result) {
            var s = true;
            if (!result.success && result.message === "NO_USER") {
                alert('Login!');
                s = false;
            }
            return s;
        };

        /**
         * 
         * @param {type} $scope
         * @param {type} $q
         * @param {type} $routeParams
         * @param {type} rowSorter
         * @param {type} uiGridConstants
         * @param {type} administratorModel
         * @returns {administratorController_L30.administratorController}
         */
        function administratorController($scope, $q, $routeParams, rowSorter, uiGridConstants, administratorModel) {

            /**
             * records sceleton
             */
            $scope.model = {
                id: null,
                firstName: null,
                lastName: null,
                email: null,
                personalCode: null,
                trashed: null
            };

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
                        sort: {
                            direction: uiGridConstants.DESC,
                            priority: 1
                        }
                    },
                    {field: 'firstName'},
                    {field: 'lastName'},
                    {field: 'email'},
                    {field: 'personalCode'},
                    {field: 'trashed'}
                ],
                enableGridMenu: true,
                enableSelectAll: true,
                exporterCsvFilename: 'administrator.csv',
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
             * GetList
             * @returns {undefined}
             */
            $scope.init = function () {

                administratorModel.GetList($scope.params).then(
                        function (result) {
                            if (_resultHandler(result)) {
                                $scope.gridOptions.data = result.data;
                            }
                        });
            };

            $scope.saveRow = function (rowEntity) {
                var promise = $q.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                administratorModel.Update(rowEntity.id, rowEntity).then(
                        function (result) {
                            if (result.success) {
                                promise.resolve();
                            } else {
                                promise.reject();
                            }
                        });
            };

            /**
             * Form reset the angular way
             * 
             * @returns {undefined}
             */
            $scope.reset = function () {
                $scope.administrator = angular.copy($scope.model);
            };

            /**
             * Create
             * 
             * @returns {undefined}
             */
            $scope.Create = function () {
               administratorModel
                        .Create(angular.copy($scope.administrator))
                        .then(
                                function (result) {
                                    if (result.success) {
                                        $scope.gridOptions.data.push(result.data);
                                        $scope.reset();
                                    } else {
                                        alert('BAD');
                                    }
                                }
                        );
            };
            $scope.init();//Start loading data from server to grid
        }

        administratorController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'administratorModel'];
        return administratorController;
    });

}(define, document));