/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tﾅ｡erepov, Marten Kﾃ､hr, Kristen Sepp, Alar Aasa, Juhan Kﾃｵks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */


(function (define, document) {
    'use strict';
    /**
     * @param angular
     * @param globalFunctions
     * @returns {roomController_L19.roomController_L25.roomController}
     */

    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

        roomController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'roomModel'];



        /**
         *
         * @param $scope
         * @param $q
         * @param $routeParams
         * @param rowSorter
         * @param uiGridConstants
         * @param roomModel
         * @returns {roomController}
         */
        function roomController($scope, $q, $routeParams, rowSorter, uiGridConstants, roomModel) {

            $scope.T = globalFunctions.T;

            var urlParams = {
                page: 1,
                limit: 1000
            };

            $scope.model = {
                id: null,
                name: null,
                trashed: null
            };

            $scope.room = {};

            $scope.filterRoom = {};


            $scope.gridOptions = {
                rowHeight: 38,
                enableCellEditOnFocus: true,
                columnDefs: [
                    {
                        field: 'id',
                        visible: false,
                        type: 'number',
                        sort:{
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
                enableSelectAll: true,
                exporterCsvFilename: 'room.csv',
                exporterPdfDefaultStyle: {fontSize: 9},
                exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color:'red'},
                exporterPdfHeader: {text:"Room Header", style: 'headerStyle'},
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
             *
             * @param gridApi
             */
            $scope.gridOptions.onRegisterApi = function (gridApi) {
                $scope.gridApi = gridApi;
                gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
            };


            /**
             *
             * @param rowEntity
             */
            $scope.saveRow = function (rowEntity) {
                var  deferred = $q.defer();
                roomModel.Update(rowEntity.id, rowEntity).then(
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

            // $scope.reset = function () {
            //     $scope.room = angular.copy($scope.model);
            // };
            /**
             *
             * @param valid
             * @constructor
             */

            $scope.Create = function (valid) {
                if (valid) {
                    roomModel.Create($scope.room).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            console.log(result);
                            $scope.gridOptions.data.push(result.data);
                            LoadGrid();
                        }
                    });
                } else {
                    globalFunctions.alertMsg('Check form fields');
                }
            };

            /**
             *
             * @constructor
             */
            $scope.Filter = function() {
                if (!angular.equals({}, $scope.items)) {
                    urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterRoom));
                    LoadGrid();
                }
            };

            /**
             *
             * @constructor
             */
            $scope.ClearFilters = function() {
                $scope.filterRoom = {};
                delete urlParams.where;
                LoadGrid();
            };

            /**
             *
             * @constructor
             */
            function LoadGrid() {
                roomModel.GetList(urlParams).then(function (result) {
                   if (globalFunctions.resultHandler(result)) {
                       $scope.gridOptions.data = result.data;
                   } 
                });
            }
            LoadGrid();
        }


        return roomController;
    });

}(define, document));


