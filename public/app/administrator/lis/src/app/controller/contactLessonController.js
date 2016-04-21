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

    define(['angular', 'app/util/globalFunctions', 'moment'],
        function (angular, globalFunctions, moment) {

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
                
                $scope.T = globalFunctions.T;

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

                $scope.formats = ['dd.MM.yyyy', 'dd-MMMM-yyyy', 'yyyy/MM/dd', 'shortDate'];
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

                $scope.contactLessonFilter = {};//for form filters, object

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
                        {//select one
                            field: "rooms",
                            name: "rooms",
                            displayName: 'LIS_ROOM',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "subjectRound",
                            name: "subjectRound",
                            displayName: 'LIS_SUBJECTROUND',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "studentGroup",
                            name: "studentGroup",
                            displayName: 'LIS_SUBJECTROUND',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "module",
                            name: "module",
                            displayName: 'LIS_MODULE',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "vocation",
                            name: "vocation",
                            displayName: 'LIS_VOCATION',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "teacher",
                            name: "teacher",
                            displayName: 'LIS_TEACHER',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {
                            field: 'name'
                        },
                        {
                            field: "lessonDate['date']",
                            name: "lessonDate['date']",
                            displayName: 'LIS_DATE',
                            type: 'date',
                            cellFilter: 'date:"yyyy-MM-dd"',
                            width: '20%'
                        },
                        {field: 'sequenceNr', type: 'number'},
                        {field: 'description'}
                    ],
                    enableGridMenu: true,
                    enableSelectAll: true,
                    exporterCsvFilename: 'modules.csv',
                    exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))
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
                    contactLessonModel.Update(rowEntity.id, rowEntity).then(
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
                 * Create new from form if succeeds push to grid
                 * 
                 * @param {type} valid
                 * @returns {undefined}
                 */
                $scope.Create = function (valid) {
                    if (valid) {
                        var buf = $scope.contactLesson.lessonDate;
                        $scope.contactLesson.lessonDate = moment($scope.contactLesson.lessonDate).format();
                        contactLessonModel.Create($scope.contactLesson).then(function (result) {
                            $scope.contactLesson.lessonDate = buf;
                            if (globalFunctions.resultHandler(result)) {
                                LoadGrid();
                            }
                        });
                    } else {
                        alert('CHECK_FORM_FIELDS');
                    }
                };

                /**
                 * 
                 * @returns {undefined}
                 */
                var resetUrlParams = function () {
                    urlParams = {
                        page: 1,
                        limit: 1000
                    };
                };

                /**
                 * Set remote criteria for DB
                 * 
                 * @returns {undefined}
                 */
                $scope.Filter = function () {
                    resetUrlParams();
                    if (!angular.equals({}, $scope.items)) {//do not send empty WHERE to BE, you'll get one nasty exception message

                        var bufDate = null,
                            data = globalFunctions.cleanData($scope.contactLessonFilter);

                        if (!!$scope.contactLessonFilter.lessonDate) {
                            bufDate = $scope.contactLessonFilter.lessonDate;
                        }

                        if (!!bufDate) {
                            data.lessonDate = moment(bufDate).format();
                        } else {
                            delete data.lessonDate;
                        }

                        if (!!data) {
                            urlParams.where = angular.toJson(data);
                        }
                    }
                    LoadGrid();
                };

                /**
                 * Remove criteria
                 * 
                 * @returns {undefined}
                 */
                $scope.ClearFilters = function () {
                    resetUrlParams();
                    $scope.contactLessonFilter = {};
                    delete urlParams.where;
                    LoadGrid();
                };

                function LoadGrid() {
                    roomModel.GetList({}).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.roomsAll = result.data;
                            $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.roomsAll;

                            subjectRoundModel.GetList({}).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    $scope.subjectRounds = result.data;
                                    $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.subjectRounds;

                                    studentGroupModel.GetList({}).then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {
                                            $scope.studentGroups = result.data;
                                            $scope.gridOptions.columnDefs[3].editDropdownOptionsArray = $scope.studentGroups;

                                            moduleModel.GetList({}).then(function (result) {
                                                if (globalFunctions.resultHandler(result)) {
                                                    $scope.modules = result.data;
                                                    $scope.gridOptions.columnDefs[4].editDropdownOptionsArray = $scope.modules;

                                                    vocationModel.GetList({}).then(function (result) {
                                                        if (globalFunctions.resultHandler(result)) {
                                                            $scope.vocations = result.data;
                                                            $scope.gridOptions.columnDefs[5].editDropdownOptionsArray = $scope.vocations;

                                                            teacherModel.GetList({}).then(function (result) {
                                                                if (globalFunctions.resultHandler(result)) {
                                                                    $scope.teachers = result.data;
                                                                    $scope.gridOptions.columnDefs[6].editDropdownOptionsArray = $scope.teachers;

                                                                    contactLessonModel.GetList(urlParams).then(function (result) {
                                                                        if (globalFunctions.resultHandler(result)) {
                                                                            $scope.gridOptions.data = result.data;
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


