/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
         * @param {type} $q
         * @param {type} $routeParams
         * @param {type} vocationModel
         * @returns {undefined}
         */
        function moduleController($scope, $q, $routeParams, uiGridConstants, moduleModel, vocationModel) {

            /*
             * id:"1"
             * name: "asd"
             * moduleCode: "56f6ca69d5aff"
             * vocation: {id: "1"}
             * moduleType: {id: "1"}
             * gradingType:[{id: 1}, {id: 2}]
             * duration:12
             * trashed: null
             */

            /**
             * records sceleton
             */
            $scope.model = {
                name: null,
                vocationCode: null,
                durationEKAP: null,
                trashed: null
            };

            /**
             * will hold vocations
             * for grid select
             */
            $scope.vocations = [];

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
                    {
                        field: "vocation['name']",
                        displayName: "Vocation",
                        editableCellTemplate: 'ui-grid/dropdownEditor',
                        editDropdownOptionsFunction: function (rowEntity, colDef) {
                            console.log(rowEntity.vocation);
                            return $scope.vocations;
                            return [{id: 'bar1', name: 'BAR 1'},
                                {id: 'bar2', name: 'BAR 2'},
                                {id: 'bar3', name: 'BAR 3'}];

                        },
                        editDropdownIdLabel: 'id',
                        editDropdownValueLabel: 'name'
                    },
//                    {
//                        name: 'gender',
//                        editableCellTemplate: 'lis/dist/templates/partial/uiSelect.html',
//                        editDropdownOptionsArray: [
//                            'male',
//                            'female',
//                            'other'
//                        ]
//                    },
//                    {name: 'gender', displayName: 'Gender', editableCellTemplate: 'ui-grid/dropdownEditor', width: '20%',
//                        cellFilter: 'mapGender', editDropdownValueLabel: 'gender', editDropdownOptionsArray: [
//                            {id: 1, gender: 'male'},
//                            {id: 2, gender: 'female'}
//                        ]},
                    {field: 'name'},
                    {field: 'moduleCode'},
                    {field: 'vocation'},
                    {field: 'moduleType'},
                    {field: 'gradingType'},
                    {field: 'duration'},
                    {field: 'trashed'}
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
//                .filter('mapGender', function () {
//                var genderHash = {
//                    1: 'male',
//                    2: 'female'
//                };
//                return function (input) {
//                    if (!input) {
//                        return '';
//                    } else {
//                        return genderHash[input];
//                    }
//                };
//            });

            /**
             * GetList
             * @returns {undefined}
             */
            $scope.init = function () {
                vocationModel.GetList({}).then(
                    function (result) {
                        if (_resultHandler(result)) {
                            console.log(result.data);
                            $scope.vocations = result.data;
                        }
                    }
                );
                moduleModel.GetList($scope.params).then(
                    function (result) {
                        if (_resultHandler(result)) {
                            $scope.gridOptions.data = result.data;
                        }
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
                moduleModel.Update(rowEntity.id, rowEntity).then(
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
                $scope.module = angular.copy($scope.model);
            };

            /**
             * Create
             * 
             * @returns {undefined}
             */
            $scope.Create = function () {

                moduleModel
                    .Create(angular.copy($scope.vocation))
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

        moduleController.$inject = ['$scope', '$q', '$routeParams', 'uiGridConstants', 'moduleModel', 'vocationModel'];

        return moduleController;
    });

}(define, document));


