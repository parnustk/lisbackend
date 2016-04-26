/** 
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * @author Juhan Kõks <juhankoks@gmail.com>
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

    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {
                teacherController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'teacherModel'];


                function teacherController($scope, $q, $routeParams, rowSorter, uiGridConstants, teacherModel) {


                    $scope.T = globalFunctions.T;
                    

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000 //unreal right :D think of remote pagination, see angular ui grid docs
                    };

                    $scope.model = {
                        id: null,
                        firstName: null,
                        lastName: null,
                        email: null,
                        personalCode: null,
                        trashed: null
                    };

                    $scope.teacher = {};
                    $scope.filterTeacher = {};

                    $scope.gridOptions = {
                        rowHeight: 38,
                        enableCellEditOnFocus: true,
                        columnDefs: [
                            {field: 'id', visible: false,
                                type: 'number',
                                enableCellEdit: false,
                                sort: {
                                    direction: uiGridConstants.DESC,
                                    priority: 1
                                }},
                            {field: 'firstName',
                                displayName: $scope.T('LIS_FIRSTNAME')},
                            {field: 'lastName',
                                displayName: $scope.T('LIS_LASTNAME')
                            },
                            {field: 'email',
                                displayName: $scope.T('LIS_EMAIL')
                            },
                            {field: 'personalCode',
                                displayName: $scope.T('LIS_PERSONALCODE')
                            },
                            {field: 'trashed',
                                displayName: $scope.T('LIS_TRASHED')}
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
                        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))

                    };

                    $scope.gridOptions.onRegisterApi = function (gridApi) {
                        //set gridApi on scope
                        $scope.gridApi = gridApi;
                        gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
                    };


                    /**
                     * Form reset the angular way
                     * 
                     * @returns {undefined}
                     */
                    $scope.reset = function () {
                        $scope.teacher = angular.copy($scope.model);
                    };



                    /**
                     * Update logic
                     * 
                     * @param {type} rowEntity
                     * @returns {undefined}
                     */
                    $scope.saveRow = function (rowEntity) {
                        var deferred = $q.defer();
                        teacherModel.Update(rowEntity.id, rowEntity).then(
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
                     * Create new from form if succeeds push to gri
                     * 
                     * @param {type} valid
                     * @returns {undefined}
                     */
                    $scope.Create = function (valid) {
                        if (valid) {
                            teacherModel.Create($scope.teacher).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    console.log(result);
                                    LoadGrid();
                                }
                            });
                        } else {
                            alert('CHECK_FORM_FIELDS');
                        }
                    };




                    /**
                     * Set remote criteria for DB
                     * 
                     * @returns {undefined}
                     */
                    $scope.Filter = function () {
                        if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                            urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterStudent));
                            LoadGrid();
                        }
                    };

                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        $scope.filterTeacher = {};
                        delete urlParams.where;
                        LoadGrid();
                    };

                    /**
                     * Before loading absence data, 
                     * we first load relations and check success
                     * 
                     * @returns {undefined}
                     */
                    function LoadGrid() {

                        teacherModel.GetList(urlParams).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.gridOptions.data = result.data;
                            }
                        });
                    }
                    LoadGrid();//let's start loading data
                }

                return teacherController;
            });

}(define, document));

