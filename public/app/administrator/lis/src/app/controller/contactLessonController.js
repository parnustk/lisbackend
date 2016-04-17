/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

/**
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            contactLessonController.$inject = [
                '$scope',
                '$q',
                '$routeParams',
                'rowSorter',
                'uiGridConstants',
                'contactLessonModel',
                'roomModel',
                'subjectRoundModel',
                'studentGroupModel',
                'moduleModel',
                'vocationModel',
                'teacherModel'
            ];

            function contactLessonController(
                $scope,
                $q,
                $routeParams,
                rowSorter,
                uiGridConstants,
                contactLessonModel,
                roomModel,
                subjectRoundModel,
                studentGroupModel,
                moduleModel,
                vocationModel,
                teacherModel) {

                $scope.today = function () {
                    $scope.dt = new Date();
                };
                $scope.today();

                $scope.showWeeks = true;
                $scope.toggleWeeks = function () {
                    $scope.showWeeks = !$scope.showWeeks;
                };

                $scope.clear = function () {
                    $scope.dt = null;
                };

                // Disable weekend selection
                $scope.disabled = function (date, mode) {
                    return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
                };

                $scope.toggleMin = function () {
                    $scope.minDate = ($scope.minDate) ? null : new Date();
                };
                $scope.toggleMin();

                $scope.open = function ($event) {
                    $event.preventDefault();
                    $event.stopPropagation();

                    $scope.opened = true;
                };

                $scope.dateOptions = {
                    'year-format': "'yy'",
                    'starting-day': 1
                };

                $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'shortDate'];
                $scope.format = $scope.formats[0];

                /**
                 * For filters and maybe later pagination
                 * 
                 * @type type
                 */
                var urlParams = {
                    page: 1,
                    limit: 100000 //unreal right :D think of remote pagination, see angular ui grid docs
                };

                /**
                 * records sceleton used for reset operations
                 */
                $scope.model = {
                    name: null,
                    lessonDate: null,
                    description: null,
                    sequenceNr: null,
                    rooms: null,
                    subjectRound: null,
                    studentGroup: null,
                    module: null,
                    vocation: null,
                    teacher: null
                };

                $scope.roomsAll = $scope.subjectRounds = $scope.studentGroups = $scope.modules = $scope.vocations = $scope.teachers = [];

                $scope.contactLesson = {};//for form, object

                $scope.filterContactLesson = {};//for form filters, object

                /**
                 * Grid set up
                 */
//                $scope.gridOptions = {
//                    rowHeight: 38,
//                    enableCellEditOnFocus: true,
//                    columnDefs: [
//                        {
//                            field: 'id',
//                            visible: false,
//                            type: 'number',
//                            enableCellEdit: false,
//                            sort: {
//                                direction: uiGridConstants.DESC,
//                                priority: 1
//                            }
//                        },
//                        {//select one
//                            field: "vocation",
//                            name: "vocation",
//                            displayName: 'Vocation',
//                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
//                            editDropdownIdLabel: "id",
//                            editDropdownValueLabel: "name",
//                            sortCellFiltered: $scope.sortFiltered,
//                            cellFilter: 'griddropdown:this'
//                        },
//                        {//select one
//                            field: "moduleType",
//                            name: "moduleType",
//                            displayName: 'Module Type',
//                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
//                            editDropdownIdLabel: "id",
//                            editDropdownValueLabel: "name",
//                            sortCellFiltered: $scope.sortFiltered,
//                            cellFilter: 'griddropdown:this'
//                        },
//                        {//select many
//                            field: 'gradingType',
//                            name: 'gradingType',
//                            displayName: 'gradingTypes',
//                            cellTemplate: "<div class='ui-grid-cell-contents'><span ng-repeat='field in COL_FIELD'>{{field.name}} </span></div>",
//                            editableCellTemplate: 'lis/dist/templates/partial/uiMultiNameSelect.html',
//                            editDropdownIdLabel: "id",
//                            editDropdownValueLabel: "name"
//                        },
//                        {field: 'name'},
//                        {field: 'moduleCode'},
//                        {field: 'duration'},
//                        {field: 'trashed'}
//                    ],
//                    enableGridMenu: true,
//                    enableSelectAll: true,
//                    exporterCsvFilename: 'modules.csv',
//                    exporterPdfDefaultStyle: {fontSize: 9},
//                    exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
//                    exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
//                    exporterPdfHeader: {text: "My Header", style: 'headerStyle'},
//                    exporterPdfFooter: function (currentPage, pageCount) {
//                        return {text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle'};
//                    },
//                    exporterPdfCustomFormatter: function (docDefinition) {
//                        docDefinition.styles.headerStyle = {fontSize: 22, bold: true};
//                        docDefinition.styles.footerStyle = {fontSize: 10, bold: true};
//                        return docDefinition;
//                    },
//                    exporterPdfOrientation: 'portrait',
//                    exporterPdfPageSize: 'LETTER',
//                    exporterPdfMaxGridWidth: 500,
//                    exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))
//                };

//                /**
//                 * Adding event handlers
//                 * 
//                 * @param {type} gridApi
//                 * @returns {undefined}
//                 */
//                $scope.gridOptions.onRegisterApi = function (gridApi) {
//                    $scope.gridApi = gridApi;
//                    gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
//                };


//                /**
//                 * Update logic
//                 * 
//                 * @param {type} rowEntity
//                 * @returns {undefined}
//                 */
//                $scope.saveRow = function (rowEntity) {
//                    var deferred = $q.defer();
//                    moduleModel.Update(rowEntity.id, rowEntity).then(
//                        function (result) {
//                            if (result.success) {
//                                deferred.resolve();
//                            } else {
//                                deferred.reject();
//                            }
//                        }
//                    );
//                    $scope.gridApi.rowEdit.setSavePromise(rowEntity, deferred.promise);
//                };

                /**
                 * Create new from form if succeeds push to grid
                 * 
                 * @param {type} valid
                 * @returns {undefined}
                 */
                $scope.Create = function (valid) {
                    if (valid) {
                        console.log($scope.contactLesson);
//                        moduleModel.Create($scope.module).then(function (result) {
//                            if (globalFunctions.resultHandler(result)) {
//                                LoadGrid();
//                            }
//                        });
                    } else {
                        alert('CHECK_FORM_FIELDS');
                    }
                };

//                /**
//                 * Set remote criteria for DB
//                 * 
//                 * @returns {undefined}
//                 */
//                $scope.Filter = function () {
//                    if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message
//                        urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterModule));
//                        LoadGrid();
//                    }
//                };
//
//                /**
//                 * Remove criteria
//                 * 
//                 * @returns {undefined}
//                 */
//                $scope.ClearFilters = function () {
//                    $scope.filterModule = {};
//                    delete urlParams.where;
//                    LoadGrid();
//                };


                /*
                 * 
                 * * name
                 * * lessonDate
                 * * description
                 * * sequenceNr
                 * * rooms r
                 * * subjectRound r 
                 * * studentGroup r
                 * * module r
                 * * vocation r
                 * * teacher r
                 */

                function LoadGrid() {
                    roomModel.GetList(urlParams).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.roomsAll = result.data;

                            subjectRoundModel.GetList(urlParams).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    $scope.subjectRounds = result.data;

                                    studentGroupModel.GetList(urlParams).then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {
                                            $scope.studentGroups = result.data;

                                            moduleModel.GetList(urlParams).then(function (result) {
                                                if (globalFunctions.resultHandler(result)) {
                                                    $scope.modules = result.data;

                                                    vocationModel.GetList(urlParams).then(function (result) {
                                                        if (globalFunctions.resultHandler(result)) {
                                                            $scope.vocations = result.data;

                                                            teacherModel.GetList(urlParams).then(function (result) {
                                                                if (globalFunctions.resultHandler(result)) {
                                                                    $scope.teachers = result.data;

                                                                    contactLessonModel.GetList(urlParams).then(function (result) {
                                                                        if (globalFunctions.resultHandler(result)) {
                                                                            //$scope.gridOptions.data = result.data;
                                                                            //alert(1);
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }

                LoadGrid();//let's start loading data
            }

            return contactLessonController;
        });

}(define, document));


