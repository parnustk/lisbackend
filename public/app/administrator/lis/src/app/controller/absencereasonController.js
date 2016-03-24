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
     * @returns {absencereasonController_L19.absencereasonController_L25.absencereasonController}
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
         * @param {type} absencereasonModel
         * @returns {undefined}
         */
        function absencereasonController($scope, $q, $routeParams, uiGridConstants, absencereasonModel) {

            /**
             * records sceleton
             */
            $scope.model = {
                name: null,
                trashed: null
            };

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
                exporterCsvFilename: 'absencereason.csv',
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
                exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")), /*
                 onRegisterApi: function (gridApi) {
                 $scope.gridApi = gridApi;
                 gridApi.cellNav.on.navigate($scope, function (newRowCol, oldRowCol) {
                 // var rowCol = {row: newRowCol.row.index, col:newRowCol.col.colDef.name};
                 // var msg = 'New RowCol is ' + angular.toJson(rowCol);
                 // if(oldRowCol){
                 //    rowCol = {row: oldRowCol.row.index, col:oldRowCol.col.colDef.name};
                 //    msg += ' Old RowCol is ' + angular.toJson(rowCol);
                 // }
                 console.log('navigation event', newRowCol, oldRowCol);
                 });
                 gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
                 }*/
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
                absencereasonModel.GetList($scope.params).then(
                        function (result) {
                            if (_resultHandler(result)) {
                                $scope.gridOptions.data = result.data;
//                            console.log($scope.gridApi);
                            }
//                        console.log($scope.store);
                        }
                );
            };

            /**
             * Update logic
             * 
             * @param {type} rowEntity
             * @returns {undefined}
             */
            $scope.saveRow = function (rowEntity) {
                var promise = $q.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                absencereasonModel.Update(rowEntity.id, rowEntity).then(
                        function (result) {
                            if (result.success) {
                                promise.resolve();
                            } else {
                                promise.reject();
                            }
                            //console.log(result);
                        });
            };

            /**
             * Form reset the angular way
             * 
             * @returns {undefined}
             */
            $scope.reset = function () {
                $scope.absencereason = angular.copy($scope.model);
            };

            /**
             * Create
             * 
             * @returns {undefined}
             */
            $scope.Create = function () {

                absencereasonModel
                        .Create(angular.copy($scope.absencereason))
                        .then(
                                function (result) {
                                    if (result.success) {
                                        console.log(result);
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

        absencereasonController.$inject = ['$scope', '$q', '$routeParams', 'uiGridConstants', 'absencereasonModel'];

        return absencereasonController;
    });

}(define, document));