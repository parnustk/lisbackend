/** 
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * @author Arnold Tserepov <tserepov@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */

/* global define */

/**
 * READ - http://brianhann.com/create-a-modal-row-editor-for-ui-grid-in-minutes/
 * http://brianhann.com/ui-grid-and-multi-select/#more-732
 * http://www.codelord.net/2015/09/24/$q-dot-defer-youre-doing-it-wrong/
 * http://stackoverflow.com/questions/25983035/angularjs-function-available-to-multiple-controllers
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
     * @returns {gradeChoiceController_L19.gradeChoiceController_L25.gradeChoiceController}
     */
    define(['angular'], function (angular) {

        /**
         * Should move to Base controller
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
         * @param {type} $routeParams
         * @param {type} gradeChoiceModel
         * @returns {undefined}
         */
        function gradeChoiceController($scope, $routeParams, uiGridConstants, gradeChoiceModel) {

            /**
             * records sceleton
             */
            $scope.model = {
                id: null,
                name: null,
                studentGrade: null,
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
                    {field: 'studentGrade'},
                    {field: 'trashed'}
                ],
                enableGridMenu: true,
                enableSelectAll: true,
                exporterCsvFilename: 'gradeChoice.csv',
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
                gradeChoiceModel.GetList($scope.params).then(
                        function (result) {
                            if (_resultHandler(result)) {
                                $scope.store = $scope.gridOptions.data = result.data;
                                //console.log($scope.gridApi);
                            }
                            //console.log($scope.store);
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
                var promise = gradeChoiceModel.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                gradeChoiceModel.Update(rowEntity.id, rowEntity).then(
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
                $scope.gradeChoice = angular.copy($scope.model);
            };

            /**
             * Create
             * 
             * @returns {undefined}
             */
            $scope.Create = function () {

                gradeChoiceModel
                        .Create(angular.copy($scope.gradeChoice))
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

        gradeChoiceController.$inject = ['$scope', '$routeParams', 'uiGridConstants', 'gradeChoiceModel'];

        return gradeChoiceController;
    });

}(define, document));


