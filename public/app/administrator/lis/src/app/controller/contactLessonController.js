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

                $scope.dt = {};

                //START datepicker

                $scope.today = function () {
                    $scope.dt = new Date();
                };
                $scope.today();

                $scope.clear = function () {
                    $scope.dt = null;
                };

                $scope.inlineOptions = {
                    customClass: getDayClass,
                    minDate: new Date(),
                    showWeeks: true
                };

                $scope.dateOptions = {
                    dateDisabled: disabled,
                    formatYear: 'yy',
                    maxDate: new Date(2020, 5, 22),
                    minDate: new Date(),
                    startingDay: 1
                };

                // Disable weekend selection
                function disabled(data) {
                    var date = data.date,
                        mode = data.mode;
                    return mode === 'day' && (date.getDay() === 0 /*|| date.getDay() === 6*/);
                }

                $scope.toggleMin = function () {
                    $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
                    $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
                };

                $scope.toggleMin();

                $scope.open1 = function () {
                    $scope.popup1.opened = true;
                };

                $scope.open2 = function () {
                    $scope.popup2.opened = true;
                };

                $scope.setDate = function (year, month, day) {
                    $scope.dt = new Date(year, month, day);
                };

                $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
                $scope.format = $scope.formats[0];
                $scope.altInputFormats = ['M!/d!/yyyy'];

                $scope.popup1 = {
                    opened: false
                };

                $scope.popup2 = {
                    opened: false
                };

                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                var afterTomorrow = new Date();
                afterTomorrow.setDate(tomorrow.getDate() + 1);
                $scope.events = [
                    {
                        date: tomorrow,
                        status: 'full'
                    },
                    {
                        date: afterTomorrow,
                        status: 'partially'
                    }
                ];

                function getDayClass(data) {
                    var date = data.date,
                        mode = data.mode;
                    if (mode === 'day') {
                        var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

                        for (var i = 0; i < $scope.events.length; i++) {
                            var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                            if (dayToCheck === currentDay) {
                                return $scope.events[i].status;
                            }
                        }
                    }

                    return '';
                }
                //END datepicker

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


