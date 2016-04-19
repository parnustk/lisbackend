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
     * @param {type} globalFunctions
     * @returns {independentWorkController_L21.independentWorkController_L32.independentWorkController}
     */
    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            independentWorkController.$inject = [
                '$scope', 
                '$q', 
                '$routeParams', 
                'rowSorter', 
                'uiGridConstants', 
                'independentWorkModel', 
                'subjectRoundModel', 
                'teacherModel', 
                'studentModel'
            ];
            /**
             * 
             * @param {type} $scope
             * @param {type} $q
             * @param {type} $routeParams
             * @param {type} rowSorter
             * @param {type} uiGridConstants
             * @param {type} independentWorkModel
             * @param {type} subjectRoundModel
             * @param {type} teacherModel
             * @param {type} studentModel
             * @returns {undefined}
             */
            function independentWorkController(
                    $scope, 
                    $q, 
                    $routeParams, 
                    rowSorter, 
                    uiGridConstants, 
                    independentWorkModel, 
                    subjectRoundModel, 
                    teacherModel, 
                    studentModel) {

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
                    id: null,
                    name: null,
                    subjectRound: null,
                    teacher: null,
                    student: null,
                    duedate: null,
                    description: null,
                    durationAK: null,
                    trashed: null
                };

                $scope.subjectRound = $scope.teacher = $scope.student = [];//for ui-select in form

                $scope.independentWork = {};//for form, object

                $scope.filterIndependentWork = {};//for form filters, object

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
                            field: "subjectRound",
                            name: "subjectRound",
                            displayName: 'Subject Round',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "teacher",
                            name: "teacher",
                            displayName: 'Teacher',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {//select one
                            field: "student",
                            name: "student",
                            displayName: 'Student',
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this'
                        },
                        {field: 'name'},
                        {field: 'duedate'},
                        {field: 'description'},
                        {field: 'durationAK'},
                        {field: 'trashed'}
                    ],
                    enableGridMenu: true,
                    enableSelectAll: true,
                    exporterCsvFilename: 'independentWorks.csv',
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
                    independentWorkModel.Update(rowEntity.id, rowEntity).then(
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
                        independentWorkModel.Create($scope.independentWork).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                console.log(result);
                                //$scope.gridOptions.data.push(result.data);
                                LoadGrid();//only needed if grid contains many column
                                //can be used for gridrefresh button
                                //maybe it is good to refresh after create?
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
                        urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterindependentWork));
                        LoadGrid();
                    }
                };

                /**
                 * Remove criteria
                 * 
                 * @returns {undefined}
                 */
                $scope.ClearFilters = function () {
                    $scope.filterindependentWork = {};
                    delete urlParams.where;
                    LoadGrid();
                };
                /**
                 * Before loading independentWork data, 
                 * we first load relations and check success
                 * 
                 * @returns {undefined}
                 */
                function LoadGrid() {

                    subjectRoundModel.GetList({}).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {

                            $scope.subjectRound = result.data;
                            $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.subjectRound;

                            teacherModel.GetList($scope.params).then(function (result) {

                                if (globalFunctions.resultHandler(result)) {

                                    $scope.teacher = result.data;
                                    $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.teacher;

                                    studentModel.GetList($scope.params).then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {

                                            $scope.student = result.data;
                                            $scope.gridOptions.columnDefs[3].editDropdownOptionsArray = $scope.student;

                                            independentWorkModel.GetList(urlParams).then(function (result) {
                                                if (globalFunctions.resultHandler(result)) {
                                                    $scope.gridOptions.data = result.data;
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

            return independentWorkController;
        });

}(define, document));