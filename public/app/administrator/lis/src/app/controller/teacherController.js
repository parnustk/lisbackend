/** 
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/* global define */

/**
 * READ - http://brianhann.com/create-a-modal-row-editor-for-ui-grid-in-minutes/
 * http://brianhann.com/ui-grid-and-multi-select/#more-732
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

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

        function teacherController($scope, $routeParams, uiGridConstants, teacherModel) {

            $scope.model = {
                id: null,
                firstName: null,
                lastName: null,
                email: null,
                personalCode: null,
                trashed: null
            };

            $scope.store = [];

            $scope.params = {};

            $scope.gridOptions = {
                enableCellEditOnFocus: true,
                columnDefs: [
                    {field: 'id', visible: false,
                        type: 'number',
                        sort: {
                            direction: uiGridConstants.DESC,
                            priority: 1
                        }},
                    {field: 'firstName'},
                    {field: 'lastName'},
                    {field: 'email'},
                    {field: 'personalCode'},
                    {field: 'trashed'}
                ],
                enableGridMenu: true,
                enableSelectAll: true,
                exporterCsvFilename: 'teacher.csv',
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
                exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))/*,
                 onRegisterApi: function (gridApi) {
                 $scope.gridApi = gridApi;
                 //                    gridApi.cellNav.on.navigate($scope, function (newRowCol, oldRowCol) {
                 //                        // var rowCol = {row: newRowCol.row.index, col:newRowCol.col.colDef.name};
                 //                        // var msg = 'New RowCol is ' + angular.toJson(rowCol);
                 //                        // if(oldRowCol){
                 //                        //    rowCol = {row: oldRowCol.row.index, col:oldRowCol.col.colDef.name};
                 //                        //    msg += ' Old RowCol is ' + angular.toJson(rowCol);
                 //                        // }
                 //                        console.log('navigation event', newRowCol, oldRowCol);
                 //                    });
                 gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
                 }*/
            };

            $scope.gridOptions.onRegisterApi = function (gridApi) {
                //set gridApi on scope
                $scope.gridApi = gridApi;
                gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
            };

            $scope.init = function () {
                teacherModel.GetList($scope.params).then(
                        function (result) {
                            if (_resultHandler(result)) {
                                $scope.store = $scope.gridOptions.data = result.data;
                                console.log($scope.gridApi);
                            }
                            console.log($scope.store);
                        }
                );
            };
            /**
             * Form reset the angular way
             * 
             * @returns {undefined}
             */
            $scope.reset = function () {
                $scope.teacher = angular.copy($scope.model);
            };


            $scope.saveRow = function (rowEntity) {
                var promise = teacherModel.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                teacherModel.Update(rowEntity.id, rowEntity).then(
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
             * Create
             * 
             * @returns {undefined}
             */
            $scope.Create = function () {

                teacherModel
                        .Create(angular.copy($scope.teacher))
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
            $scope.init();

        }

        teacherController.$inject = ['$scope', '$routeParams', 'uiGridConstants', 'teacherModel'];

        return teacherController;
    });

}(define, document));

