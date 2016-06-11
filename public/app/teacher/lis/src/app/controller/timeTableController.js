/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */


/**
 *   @author Juhan Kõks <juhankoks@gmail.com>
 *   @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */


/* global define */

/**
 * 
 * @param {type} window
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
     * @param {type} moment
     * @returns {timeTableController.timeTableController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                timeTableController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'studentModel',
                    'contactLessonModel',
                    'subjectRoundModel',
                    'teacherModel',
                    'roomModel',
                    'studentGroupModel'
                ];

                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} studentModel
                 * @param {type} contactLessonModel
                 * @param {type} subjectRoundModel
                 * @param {type} teacherModel
                 * @param {type} roomModel
                 * @param {type} studentGroupModel
                 * @returns {timeTableController.timeTableController}
                 */
                function timeTableController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        studentModel,
                        contactLessonModel,
                        subjectRoundModel,
                        teacherModel,
                        roomModel,
                        studentGroupModel
                        ) {

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


                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        resetUrlParams();
                        $scope.teacherTimeTableFilter = {};
                        delete urlParams.where;
                        LoadData();
                    };

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100,
                        teacherTimeTable: true
                    };

                    var resetUrlParams = function () {
                        urlParams = {
                            page: 1,
                            limit: 100,
                            teacherTimeTable: true
                        };
                    };

                    $scope.teacherTimeTableFilter = {};

                    $scope.studentGroups = $scope.subjectRounds = $scope.teachers = $scope.rooms = [];

                    $scope.FormatDate = function (ds) {

                        //var dObj = new Date(ds),
                            var    dFinal;

                        if (window.LisGlobals.L === 'et') {
                            dFinal = moment(ds).format('DD.MM.YYYY');
                        } else {
                            dFinal = moment(ds).format('DD/MM/YYYY');
                        }
                        return dFinal;




                    };

                    /**
                     * 
                     * @param {type} valid
                     * @returns {undefined}
                     */
                    $scope.Filter = function (valid) {
                        resetUrlParams();
                        if (valid) {
                            urlParams.startDate = moment($scope.teacherTimeTableFilter.startDate).format('YYYY-MM-DD');
                            urlParams.endDate = moment($scope.teacherTimeTableFilter.endDate).format('YYYY-MM-DD');
                            LoadData();

                        } else {
                            alert('error');
                        }
                    };

                    $scope.dateFilter = function (items, startDate, endDate) {
                        startDate = parseDate(startDate);
                        endDate = parseDate(endDate);
                        var result = [];
                        for (var i = 0; i < items.length; i++) {
                            var searchStartDate = new Date(),
                                    searchEndDate = new Date(items[i].date2 * 1000);
                            if (searchStartDate > startDate && searchEndDate < endDate) {
                                result.push(items[i]);
                            }
                        }
                        return result;
                    };

                    /**
                     * 
                     * @returns {undefined}
                     */
                    function LoadData() {
                        subjectRoundModel.GetList(urlParams).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.subjectRounds = result.data;

//                                studentGroupModel.GetList(urlParams).then(function (result) {
//                                    if (globalFunctions.resultHandler(result)) {
//                                        $scope.studentGroups = result.data;
//                                    }
//                                });
                            }
                        });
                    }

                    LoadData();//let's start loading data
                }

                return timeTableController;
            });

}(window, define, document));


