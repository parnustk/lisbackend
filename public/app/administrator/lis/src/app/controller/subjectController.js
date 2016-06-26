/* global define */

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * 
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Sander Mets <sandermets0@gmail.com>
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
     * @returns {subjectController_L22.subjectController_L34.subjectController}
     */
    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            subjectController.$inject = [
                '$scope',
                '$q',
                'uiGridConstants',
                'subjectModel',
                'moduleModel',
                'gradingTypeModel'
            ];

            /**
             * 
             * @param {type} $scope
             * @param {type} $q
             * @param {type} uiGridConstants
             * @param {type} subjectModel
             * @param {type} moduleModel
             * @param {type} gradingTypeModel
             * @returns {undefined}
             */
            function subjectController(
                $scope,
                $q,
                uiGridConstants,
                subjectModel,
                moduleModel,
                gradingTypeModel) {

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

                $scope.modules = [];

                $scope.gradingTypes = [];

                $scope.subject = {};

                $scope.filterSubject = {};

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
                        }, {
                            field: "module",
                            name: "module",
                            displayName: $scope.T('LIS_MODULE'),
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        }, {
                            field: "gradingType",
                            name: 'gradingType',
                            displayName: $scope.T('LIS_GRADINGTYPE'),
                            cellTemplate: "<div class='ui-grid-cell-contents'><span ng-repeat='field in COL_FIELD'>{{field.name}} </span></div>",
                            editableCellTemplate: 'lis/dist/templates/partial/uiMultiNameSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name"
                        }, {
                            field: 'name',
                            displayName: $scope.T('LIS_NAME')
                        }, {
                            field: 'subjectCode',
                            displayName: $scope.T('LIS_SUBJECTCODE')
                        }, {
                            field: 'durationAllAK',
                            displayName: $scope.T('LIS_DURATIONALLAK')
                        }, {
                            field: 'durationContactAK',
                            displayName: $scope.T('LIS_DURATIONCONTACTAK')
                        }, {
                            field: 'durationIndependentAK',
                            displayName: $scope.T('LIS_DURATIONINDEPENDENTAK')
                        }, {
                            field: 'trashed',
                            displayName: $scope.T('LIS_TRASHED')
                        }
                    ],
                    enableGridMenu: true,
                    enableSelectAll: true,
                    exporterCsvFilename: 'subjects.csv',
                    exporterPdfDefaultStyle: {
                        fontSize: 9
                    },
                    exporterPdfTableStyle: {
                        margin: [
                            30, 30, 30, 30
                        ]
                    },
                    exporterPdfTableHeaderStyle: {
                        fontSize: 10,
                        bold: true,
                        italics: true,
                        color: 'red'
                    },
                    exporterPdfHeader: {
                        text: "My Header",
                        style: 'headerStyle'
                    },
                    exporterPdfFooter: function (currentPage, pageCount) {
                        return {
                            text: currentPage.toString() + ' of ' +
                                pageCount.toString(),
                            style: 'footerStyle'
                        };
                    },
                    exporterPdfCustomFormatter: function (docDefinition) {
                        docDefinition.styles.headerStyle = {
                            fontSize: 22,
                            bold: true
                        };
                        docDefinition.styles.footerStyle = {
                            fontSize: 10,
                            bold: true
                        };
                        return docDefinition;
                    },
                    exporterPdfOrientation: 'portrait',
                    exporterPdfPageSize: 'LETTER',
                    exporterPdfMaxGridWidth: 500,
                    exporterCsvLinkElement: angular.element(
                        document.querySelectorAll(".custom-csv-link-location"))
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

                $scope.saveRow = function (rowEntity) {
                    var deferred = $q.defer();
                    subjectModel.Update(rowEntity.id, rowEntity).then(
                        function (result) {
                            if (result.success) {
                                deferred.resolve();
                            } else {
                                deferred.reject();
                            }
                        });
                    $scope.gridApi.rowEdit.setSavePromise(rowEntity, deferred.promise);
                };

                /**
                 * Create new from form if succeeds reload grid
                 * 
                 * @param {type} valid
                 * @returns {undefined}
                 */
                $scope.Create = function (valid) {
                    if (valid) {
                        subjectModel.Create($scope.subject).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                LoadGrid();
                            }
                        });
                    } else {
                        globalFunctions.alertMsg('Check form fields');
                    }
                };

                /**
                 * Set remote criteria for DB
                 * 
                 * @returns {undefined}
                 */
                $scope.Filter = function () {
                    if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
                        urlParams.where = angular.toJson(
                            globalFunctions.cleanData($scope.filterSubject));
                        LoadGrid();
                    }
                };

                /**
                 * Remove criteria
                 * 
                 * @returns {undefined}
                 */
                $scope.ClearFilters = function () {
                    $scope.filterSubject = {};
                    delete urlParams.where;
                    LoadGrid();
                };

                /**
                 * Before loading module data, 
                 * we first load relations and check success
                 * 
                 * @returns {undefined}
                 */
                function LoadGrid() {
                    moduleModel.GetList({}).then(function (result) {
                        $scope.gridOptions.data = [];
                        if (globalFunctions.resultHandler(result)) {

                            $scope.modules = result.data;
                            $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.modules;

                            gradingTypeModel.GetList($scope.params).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {

                                    $scope.gradingTypes = result.data;
                                    $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.gradingTypes;

                                    subjectModel.GetList(urlParams).then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {
                                            $scope.gridOptions.data = result.data;
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
                
                LoadGrid();
            }

            return subjectController;
        });

}(define, document));
