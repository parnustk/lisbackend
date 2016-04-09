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
         * @param {type} rowSorter
         * @param {type} uiGridConstants
         * @param {type} moduleModel
         * @param {type} vocationModel
         * @returns {undefined}
         */
        function moduleController($scope, $q, $routeParams, rowSorter, uiGridConstants, moduleModel, vocationModel, moduletypeModel, gradingTypeModel) {

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
                moduleCode: null,
                vocation: null,
                moduleType: null,
                gradingType: null,
                duration: null
            };

            /**
             * will hold vocations
             * for grid select
             */
            $scope.vocations = [];
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
                        visible: true,
                        type: 'number',
                        enableCellEdit: false,
                        sort: {
                            direction: uiGridConstants.DESC,
                            priority: 1
                        }
                    },
                    {
                        field: "vocation",
                        name: "vocation",
                        displayName: 'Vocation',
                        editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "name",
                        editDropdownOptionsFunction: function (rowEntity, colDef) {
                            return $scope.vocations;
                        },
                        sortCellFiltered: $scope.sortFiltered,
                        cellFilter: 'griddropdown:this'
                    },
                    {//gradingType many to many
                        field: 'gradingType',
                        name: 'gradingType',
                        displayName: 'gradingTypes',
                        cellTemplate: "<div class='ui-grid-cell-contents'><span ng-repeat='field in COL_FIELD'>{{field.name}} </span></div>",
                        editableCellTemplate: 'lis/dist/templates/partial/uiMultiNameSelect.html',
                        editDropdownIdLabel: "id",
                        editDropdownValueLabel: "name",
                        editDropdownOptionsFunction: function (rowEntity, colDef) {
                            return $scope.gradingTypes;
                        }

                    }
                ]
            };

            /**
             * Adding event handlers
             * 
             * @param {type} gridApi
             * @returns {undefined}
             */
            $scope.gridOptions.onRegisterApi = function (gridApi) {
                $scope.gridApi = gridApi;
                gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
            };

            vocationModel.GetList({}).then(function (result) {
                if (_resultHandler(result)) {

                    $scope.vocations = result.data;
                    $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.vocations;

                    gradingTypeModel.GetList($scope.params).then(function (result) {
                        if (_resultHandler(result)) {
                            $scope.gradingTypes = result.data;
                            $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.gradingTypes;

                            moduleModel.GetList($scope.params).then(function (result) {
                                if (_resultHandler(result)) {
                                    $scope.modules = result.data;
                                    $scope.gridOptions.data = $scope.modules;
                                }
                            });

                        }
                    });

                }
            });


            /**
             * Update logic
             * 
             * @param {type} rowEntity
             * @returns {undefined}
             */
            $scope.saveRow = function (rowEntity) {
                var deferred = $q.defer();
                moduleModel.Update(rowEntity.id, rowEntity).then(
                    function (result) {
                        if (result.success) {
                            deferred.resolve();
                        } else {
                            deferred.reject();
                        }
                    });
                $scope.gridApi.rowEdit.setSavePromise(rowEntity, deferred.promise);
            };

        }

        moduleController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'moduleModel', 'vocationModel', 'moduletypeModel', 'gradingTypeModel'];
        
        return moduleController;
    });

}(define, document));


