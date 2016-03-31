/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
(function (define, document) {
    'use strict';
    /**
     *  @param {type} angular
     *  @returns {roomController_L19.roomController_L25.roomController}
     */

    define(['angular'], function (angular) {


        /**
         *
         * @param {Object} result
         * @returns {boolean}
         */
        var _resultHandler = function (result){
            var s = true;
            if (!result.success && result.message === "NO_USER") {
                alert('Login!');
                s = false;
            }
            return s;
        };


        /**
         *
         * @param $scope
         * @param $q
         * @param $routeParams
         * @param uiGridConstants
         * @param roomModel
         */
        function roomController($scope, $q, $routeParams, uiGridConstants, roomModel) {

            $scope.model = {
                name: null,
                trashed: null
            };


            $scope.gridOptions = {
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
                    {field: 'name'},
                    {field: 'trashed'}
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
                exporterCsvLinkElement: angular.element(document.querySelectorAll(".custon-csv-link-location"))

            };

            /**
             *
             * @param gridApi
             */
            $scope.gridOptions.onRegisterApi = function (gridApi) {
                $scope.gridApi = gridApi;
                gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
            };



            $scope.init = function(){
                roomModel.GetList($scope.params).then(
                    function (result) {
                        if(_resultHandler(result)) {
                            $scope.gridOptions.data = result.data;
                        }
                    }
                );
            };

            /**
             *
             * @param rowEntity
             */
            $scope.saveRow = function (rowEntity) {
                var  promise = $q.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                roomModel.Update(rowEntity.id, rowEntity).then(
                    function (result) {
                        if (result.success) {
                            promise.resolve();
                        } else {
                            promise.reject();
                        }
                    }
                );
            };

            $scope.reset = function () {
                $scope.room = angular.copy($scope.model);
            };

            $scope.Create = function () {
                roomModel
                        .Create(angular.copy($scope.room))
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

        roomController.$inject = ['$scope', '$q', '$routeParams', 'uiGridConstants', 'roomModel'];

        return roomController;
    });

}(define, document));


