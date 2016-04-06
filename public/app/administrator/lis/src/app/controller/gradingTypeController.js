/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
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
     * @returns {gradingTypeController_L19.gradingTypeController_L25.gradingTypeController}
     */
    define(['angular', 'jquery', 'foundation'], function (angular, $, Foundation) {
        
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

        function gradingTypeController($scope, $q, $routeParams, uiGridConstants, gradingTypeModel) {
            
            var elem = new Foundation.DropdownMenu($('#main-menu'));
            /**
             * records sceleton
             */
            $scope.model={
                gradingType: null,
                trashed: null
            };
            
            /**
             * Grid set up
             */
            $scope.gridOptions ={
                enableCellEditOnFocus: true,
                columnDefs:[{
                        field: 'id',
                        visible: false,
                        type: 'number',
                        sort:{
                            direction: uiGridConstants.DESC,
                            priority: 1
                        }
                },
                {field: 'gradingType'},
                {field: 'trashed'}
            ],
            enableGridMenu: true,
            enalbeSelectAll: true,
            exporterCsvFilename: 'gradingtype.csv',
            exporterPdfDefaultStyle: {fontSize: 9},
                exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color:'red'},
                exporterPdfHeader: {text:"Grading Type Header", style: 'headerStyle'},
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
                gradingTypeModel.GetList($scope.params).then(
                    function (result) {
                        if (_resultHandler(result)) {
                            $scope.gridOptions.data = result.data;
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
                var promise = $q.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                gradingTypeModel.Update(rowEntity.id, rowEntity).then(
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
                $scope.gradingType = angular.copy($scope.model);
            };
            
            /**
             * Create
             * 
             * @returns {undefined}
             */
            $scope.Create = function () {
                gradingTypeModel
                        .Create(angular.copy($scope.gradingType))
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
            
            /**
             * Delete
             * kustutab küll vaatest aga mitte andmebaasist :/
             */
            $scope.Delete = function () {
                angular.forEach($scope.gridApi.selection.getSelectedRows(), 
                    function (data, index) {
                        $scope.gridOptions.data.splice($scope.gridOptions.data.lastIndexOf(data), 1);
                    });
            }
            $scope.init();
        }

        gradingTypeController.$inject = ['$scope', '$q', '$routeParams', 'uiGridConstants', 'gradingTypeModel'];

        return gradingTypeController;
    });

}(define, document));


