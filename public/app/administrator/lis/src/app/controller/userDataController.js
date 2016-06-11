/** 
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

/* global define */
/**
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */

/**
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
     * @param {type} globalFunctions
     * @returns {}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                userDataController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'userDataModel',
                ];

                function userDataController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        userDataModel) {

                    $scope.T = globalFunctions.T;

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000,
//                        usermng: 'usermng'
                    };

                    /**
                     * records sceleton used for reset operations
                     */
                    $scope.model = {
                        firstName: null,
                        lastName: null,
                        email: null,
                        personalCode: null,
                        trashed: null
                    };

                    $scope.module = {};//for form, object

                    $scope.filterModule = {};//for form filters, object

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
                                enableCellEdit: false,
                                sort: {
                                    direction: uiGridConstants.DESC,
                                    priority: 1
                                }
                            },
                            {
                                field: 'firstName',
                                displayName: $scope.T('LIS_FIRSTNAME')
                            },
                            {
                                field: 'lastName',
                                displayName: $scope.T('LIS_LASTNAME')
                            },
                            {
                                field: 'email',
                                displayName: $scope.T('LIS_EMAIL')
                            },
                            {
                                field: 'personalCode',
                                displayName: $scope.T('LIS_PERSONALCODE')
                            },
                            {
                                field: 'trashed',
                                displayName: $scope.T('LIS_TRASHED')
                            }
                        ],
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

                    /**
                     * Update logic
                     * 
                     * @param {type} rowEntity
                     * @returns {undefined}
                     */
                    $scope.saveRow = function (rowEntity) {
                        var deferred = $q.defer();
                        userDataModel.Update(rowEntity.id, rowEntity).then(
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

                    /**
                     * Set remote criteria for DB
                     * 
                     * @returns {undefined}
                     */
                    $scope.Filter = function () {
                        if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterModule));
                            LoadGrid();
                        }
                    };

                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        $scope.filterModule = {};
                        delete urlParams.where;
                        LoadGrid();
                    };


                    /**
                     * Before loading lisUser data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadData() {

                        userDataModel.Get(1/*siia peaks tulema kasutaja adminid*/).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.gridOptions.data = result.data;
                            }
                        });    
                    }

                    LoadData();//let's start loading data
                }

                return userDataController;
            });

}(define, document));
