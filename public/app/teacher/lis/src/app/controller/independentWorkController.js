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
 * Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/**
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (window, define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {independentWorkController_L21.independentWorkController_L32.independentWorkController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                independentWorkController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'independentWorkModel',
                    'subjectRoundModel',
                    'studentGroupModel',
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
                 * @param {type} studentGroupModel
                 * @param {type} teacherModel
                 * @param {type} studentModel
                 * @returns {independentWorkController_L35.independentWorkController}
                 */
                function independentWorkController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        independentWorkModel,
                        subjectRoundModel,
                        studentGroupModel,
                        teacherModel,
                        studentModel) {

                    $scope.dt = {};
                    $scope.T = globalFunctions.T;

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
                        limit: 100000
                    };

                    /**
                     * records sceleton used for reset operations
                     */
                    $scope.model = {
                        id: null,
                        name: null,
                        duedate: null,
                        description: null,
                        durationAK: null,
                        trashed: null,
                        subjectRound: null,
                        student: null
                    };

                    $scope.subjectRounds = [];
                    $scope.students = [];//for ui-select in form

                    $scope.independentWork = {};//for form, object

                    $scope.independentWorkFilter = {};

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
                                displayName: $scope.T('LIS_SUBJECTROUND'),
                                editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                                editDropdownIdLabel: "id",
                                editDropdownValueLabel: "name",
                                sortCellFiltered: $scope.sortFiltered,
                                cellFilter: 'griddropdown:this'
                            },
                            {
                                field: "name",
                                displayName: $scope.T('LIS_NAME')
                            },
                            {
                                field: "duedate['date']",
                                name: "duedate['date']",
                                displayName: $scope.T('LIS_DUEDATE'),
                                type: "date",
                                cellFilter: 'date:"yyyy-MM-dd"',
                                width: '20%'
                            },
                            {
                                field: "description",
                                displayName: $scope.T('LIS_DESCRIPTION')
                            },
                            {
                                field: "durationAK",
                                displayName: $scope.T('LIS_DURATIONINDEPENDENTAK')
                            }
                        ],
                        enableGridMenu: true,
                        enableSelectAll: true,
                        exporterCsvFilename: 'independentWorks.csv',
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
                            var buf = $scope.independentWork.duedate;
                            $scope.independentWork.duedate = moment($scope.independentWork.duedate).format();
                            independentWorkModel.Create($scope.independentWork).then(function (result) {
                                $scope.independentWork.duedate = buf;
                                if (globalFunctions.resultHandler(result)) {
                                    LoadGrid();
                                }
                            });
                        } else {
                            globalFunctions.alertMsg('Check form fields');
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
                        if (!angular.equals({}, $scope.items)) {
                            var bufDate = null,
                                    data = globalFunctions.cleanData($scope.independentWorkFilter);

                            if (!!$scope.independentWorkFilter.duedate) {
                                bufDate = $scope.independentWorkFilter.duedate;
                            }

                            if (!!bufDate) {
                                data.duedate = moment(bufDate).format();
                            } else {
                                delete data.duedate;
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
                        $scope.independentWorkFilter = {};
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

                                $scope.subjectRounds = result.data;
                                $scope.gridOptions.columnDefs[1].editDropdownOptionsArray = $scope.subjectRounds;

                                independentWorkModel.GetList(urlParams).then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {
                                        $scope.gridOptions.data = result.data;

                                    }
                                });
                            }
                        });
                    }

                    LoadGrid();//let's start loading data
                }

                return independentWorkController;
            });

}(window, define, document));
