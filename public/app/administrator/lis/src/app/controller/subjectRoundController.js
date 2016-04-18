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
     * @returns {subjectRoundController_L19.subjectRoundController_L25.subjectRoundController}
     */

    /**
     * @returns (subjectRoundController_L21.subjectRoundController_L32.subjectRoundController)
     */
    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            subjectRoundController.$inject = ['$scope', '$q', '$routeParams', 'rowSorter', 'uiGridConstants', 'subjectRoundModel', 'subjectModel', 'studentGroupModel'];


            /**
             *
             * @param $scope
             * @param $q
             * @param $routeParams
             * @param rowSorter
             * @param uiGridConstants
             * @param subjectRoundModel
             * @param subjectModel
             * @param studentGroupModel
             */
            function subjectRoundController($scope, $q, $routeParams, rowSorter, uiGridConstants, subjectRoundModel, subjectModel, studentGroupModel) {

                var urlParams = {
                    page: 1,
                    limit: 1000
                };

                $scope.model = {
                    id: null,
                    name: null,
                    subject: null,
                    studentGroup: null,
                    trashed: null
                };



                $scope.subject = $scope.studentGroup = [];

                $scope.subjectRound = {};
                $scope.filterSubjectRound = {};


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
                        {
                            field: "subject",
                            name: "subject",
                            displayName: "Subject",
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {
                            field: "studentGroup",
                            name: "studentGroup",
                            displayName: "Student Group",
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {field: 'name'},
                        {field: 'trashed'}
                    ],
                    enableGridMenu: true,
                    enableSelectAll: true,
                    exporterCsvFilename: 'subjectround.csv',
                    exporterPdfDefaultStyle: {fontSize: 9},
                    exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                    exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color:'red'},
                    exporterPdfHeader: {text:"Subject round Header", style: 'headerStyle'},
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
                    subjectRoundModel.Update(rowEntity.id, rowEntity).then(
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
                        subjectRoundModel.Create($scope.subjectRound).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                console.log(result);
                                //$scope.gridOptions.data.push(result.data);
                                LoadGrid();
                            }
                        });
                    } else {
                        alert('CHECK_FORM_FIELDS');
                    }
                };

                /**
                 *
                 * @constructor
                 */
                $scope.Filter = function() {
                    if (!angular.equals({}, $scope.items)) {
                        urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterSubjectRound));
                        LoadGrid();
                    }
                };

                /**
                 *
                 * @constructor
                 */
                $scope.ClearFilters = function() {
                    $scope.filterSubjectRound = {};
                    delete urlParams.where;
                    LoadGrid();
                };

                /**
                 *
                 * @constructor
                 */
                function LoadGrid() {
                    subjectModel.GetList(urlParams).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.subject = result.data;
                            $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.subject;

                            studentGroupModel.GetList(urlParams).then(function (result) {
                                $scope.studentGroup = result.data;
                                $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.studentGroup;

                                subjectRoundModel.GetList(urlParams).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {
                                        $scope.gridOptions.data = result.data;
                                    }
                                });
                            });
                        }
                    });
                }
                LoadGrid();
            }


            return subjectRoundController;
        });

}(define, document));


