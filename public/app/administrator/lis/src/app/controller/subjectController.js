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
     * @returns {subjectController_L28.subjectController}
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
         * @param {type} subjectModel
         * @returns {undefined}
         */
        function subjectController($scope, $q, $routeParams, rowSorter, uiGridConstants, subjectModel) {

            /**
             * records sceleton
             */
            $scope.model = {
                id: null,
                subjectCode: null,
                name: null,
                durationAllAK: null,
                durationContactAK : null,
                durationIndependentAK: null,
                module: null,
                gradingType: null,
                trashed: null
            };
            
            /**
             * will hold modules
             * for grid select
             */
            $scope.modules = [];
            
            /**
             * will hold gradingTypes
             * for grid select
             */
            $scope.gradingTypes = [];

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
                    {field: 'subjectCode'},
                    {field: 'name'},
                    {field: 'durationAllAK'},
                    {field: 'durationContactAK'},
                    {field: 'durationIndependentAK'},
                    {field: 'module'},
                    {field: 'gradingType'},
                    {field: 'trashed'}
                ],
                enableGridMenu: true,
                enableSelectAll: true,
                exporterCsvFilename: 'subject.csv',
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

                subjectModel.GetList($scope.params).then(
                        function (result) {
                            if (_resultHandler(result)) {
                                $scope.gridOptions.data = result.data;
                            }
                        });
            };

            $scope.saveRow = function (rowEntity) {
                var promise = $q.defer();
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
                subjectModel.Update(rowEntity.id, rowEntity).then(
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
                $scope.subject = angular.copy($scope.model);
            };

            /**
             * Create
             * 
             * @returns {undefined}
             */
            $scope.Create = function () {
                subjectModel
                        .Create(angular.copy($scope.subject))
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

        subjectController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'subjectModel'];
        return subjectController;
    });

}(define, document));